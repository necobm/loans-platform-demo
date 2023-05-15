<?php

namespace Loans\Domain\Model;

use App\Loans\Domain\Exception\InvalidFinancialPreferencesException;
use App\Loans\Domain\Model\Client;
use App\Loans\Domain\Model\ClientFinancialPreferences;
use App\Loans\Domain\Model\Product;
use App\Loans\Domain\Model\ProductType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductTest extends KernelTestCase
{
    public function testGetClientFinancialCompatibilityScoreReturnPositiveScore(): void
    {
        $client = $this->buildTestClient();
        $product = $this->buildTestProduct();

        $score = $product->getClientFinancialCompatibilityScore($client);

        $this->assertGreaterThan(0, $score);
    }


    public function testGetClientFinancialCompatibilityScoreThrowsException(): void
    {
        $this->expectException(InvalidFinancialPreferencesException::class);
        $client = $this->buildTestClient();
        $client->setFinancialPreferences(null);
        $product = $this->buildTestProduct();

        $score = $product->getClientFinancialCompatibilityScore($client);
    }

    /**
     * @dataProvider getClientFinancialCompatibilityScoreDataProvider
     * @param Client $client
     * @param Product $product
     * @return void
     */
    public function testGetClientFinancialCompatibilityScoreReturnZeroScore(Client $client, Product $product): void
    {
        $score = $product->getClientFinancialCompatibilityScore($client);
        $this->assertEquals(0, $score);
    }

    public static function getClientFinancialCompatibilityScoreDataProvider(): array
    {
        return [
            [   // The client incomes are lower than minimal requirements for Product
                'client' => self::buildTestClient([
                    'monthlyIncome' => 800
                ]),
                'product' => self::buildTestProduct([
                    'minimalIncomeRequirement' => 1000
                ])
            ],
            [   // The client monthly spends are too high, despite his income are greater than the minimal incomes
                // the product requires
                'client' => self::buildTestClient([
                    'monthlyIncome' => 2500,
                    'monthlySpends' => 2000
                ]),
                'product' => self::buildTestProduct([
                    'minimalIncomeRequirement' => 1000
                ])
            ],
            [
                // The client age plus the loan term in years that he want, goes over the age limit (80 years)
                'client' => self::buildTestClient([
                    'age' => 70,
                    'financialPreferences' => self::buildTestClientPreferences([
                        'maxTerm' => 15
                    ])
                ]),
                'product' => self::buildTestProduct()
            ],
            [
                // The product type required for the client is not the same of the product
                'client' => self::buildTestClient([
                    'financialPreferences' => self::buildTestClientPreferences([
                        'productType' => self::buildProductType([
                            'value' => 2
                        ])
                    ])
                ]),
                'product' => self::buildTestProduct()
            ],
            [
                // The loan amount required for the client is greater than the maximum allowed for the product
                'client' => self::buildTestClient([
                    'financialPreferences' => self::buildTestClientPreferences([
                        'loanAmount' => 20000
                    ])
                ]),
                'product' => self::buildTestProduct()
            ],
            [
                // The maxTerm in years required by the client is higher than the maxTerm of the Product
                'client' => self::buildTestClient([
                    'financialPreferences' => self::buildTestClientPreferences([
                        'maxTerm' => 10
                    ])
                ]),
                'product' => self::buildTestProduct()
            ]
        ];
    }

    private static function buildTestClient(array $data = []): Client
    {
        $client = new Client();
        $client->setCity($data['city'] ??'Sevilla');
        $client->setAge($data['age'] ?? 35);
        $client->setEmail($data['email'] ?? 'testEmail@email.com');
        $client->setName($data['name'] ?? 'name');
        $client->setSurname($data['surname'] ?? 'surname');
        $client->setNetMonthlyIncome($data['monthlyIncome'] ?? 3000);
        $client->setTotalMonthlySpends($data['monthlySpends'] ?? 800);
        $client->setFinancialPreferences($data['financialPreferences'] ?? self::buildTestClientPreferences());

        return $client;
    }

    private static function buildTestClientPreferences(array $data = []): ClientFinancialPreferences
    {
        $financialPreferences = new ClientFinancialPreferences();
        $financialPreferences->setLoanAmount($data['loanAmount'] ?? 500);
        $financialPreferences->setMaxTerm($data['maxTerm'] ?? 2);

        $financialPreferences->setProductType($data['productType'] ?? self::buildProductType());

        return $financialPreferences;
    }

    private static function buildTestProduct(array $data = []): Product
    {
        $product = new Product();
        $product->setName($data['name'] ?? 'Tarjeta crédito');
        $product->setMaxTerm($data['maxTerm'] ?? 5);
        $product->setInterestRate($data['interestRate'] ?? 8.5);
        $product->setType(self::buildProductType());
        $product->setMaxAmount($data['maxAmount'] ?? 10000);
        $product->setAdicionalCosts(0);
        $product->setMinimalIncomeRequirement($data['minimalIncomeRequirement'] ?? 200);

        return $product;
    }

    private static function buildProductType(array $data = []): ProductType
    {
        $productType = new ProductType();
        $productType->setName($data['name'] ?? 'Tarjeta de crédito');
        $productType->setValue($data['value'] ?? 1);

        return $productType;
    }
}
