<?php

namespace App\Loans\Domain\Model;

use App\Loans\Domain\Exception\ExceededLoanAmountException;
use App\Loans\Domain\Exception\InvalidFinancialPreferencesException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=false)
     */
    private string $name;
    /**
     * @var float
     *
     * @ORM\Column(name="interest_rate", type="float", precision=2, nullable=false)
     */
    private float $interestRate;
    /**
     * @var int
     *
     * @ORM\Column(name="max_term", type="integer", nullable=false)
     */
    private int $maxTerm;
    /**
     * @var float
     *
     * @ORM\Column(name="max_amount", type="float", precision=2, nullable=false)
     */
    private float $maxAmount;
    /**
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumn(name="product_type_id", nullable=false)
     */
    private ProductType $type;
    /**
     * @var float
     *
     * @ORM\Column(name="minimal_income_requirement", type="float", precision=2, nullable=true)
     */
    private float $minimalIncomeRequirement = 0;
    /**
     * @var float
     *
     * @ORM\Column(name="adicional_costs", type="float", precision=2, nullable=true)
     */
    private float $adicionalCosts = 0;
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    /**
     * @param float $interestRate
     */
    public function setInterestRate(float $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return int
     */
    public function getMaxTerm(): int
    {
        return $this->maxTerm;
    }

    /**
     * @param int $maxTerm
     */
    public function setMaxTerm(int $maxTerm): void
    {
        $this->maxTerm = $maxTerm;
    }

    /**
     * @return float
     */
    public function getMaxAmount(): float
    {
        return $this->maxAmount;
    }

    /**
     * @param float $maxAmount
     */
    public function setMaxAmount(float $maxAmount): void
    {
        $this->maxAmount = $maxAmount;
    }

    /**
     * @return ProductType
     */
    public function getType(): ProductType
    {
        return $this->type;
    }

    /**
     * @param ProductType $type
     */
    public function setType(ProductType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getMinimalIncomeRequirement(): float
    {
        return $this->minimalIncomeRequirement;
    }

    /**
     * @param float $minimalIncomeRequirement
     */
    public function setMinimalIncomeRequirement(float $minimalIncomeRequirement): void
    {
        $this->minimalIncomeRequirement = $minimalIncomeRequirement;
    }

    /**
     * @return float
     */
    public function getAdicionalCosts(): float
    {
        return $this->adicionalCosts;
    }

    /**
     * @param float $adicionalCosts
     */
    public function setAdicionalCosts(float $adicionalCosts): void
    {
        $this->adicionalCosts = $adicionalCosts;
    }

    /**
     * @throws InvalidFinancialPreferencesException
     */
    public function getClientFinancialCompatibilityScore(Client $client): int
    {
        // First we check if the product is compatible with the user preferences

        // User preferences have been defined before by the Chat Bot
        if (is_null($client->getFinancialPreferences())) {
           throw new InvalidFinancialPreferencesException();
        }

        $clientPreferences = $client->getFinancialPreferences();

        if ($this->getType()->getValue() !== $clientPreferences->getProductType()->getValue()
            || $this->maxAmount < $clientPreferences->getLoanAmount()
            || $this->maxTerm < $clientPreferences->getMaxTerm()
        ) {
            // Client preferences are incompatible with this product
            return 0;
        }

        //Calculate score based on Product features and User personal and financial information
        //If any of the requisites is not reached, the product is considered incompatible and scores 0

        $score = 0;

        //Score by user age, as youngest the user, more score will give
        if (($client->getAge() + $this->maxTerm) < 80) {
            $totalYears = $client->getAge() + $this->maxTerm;
            $score = 100 - ( ($totalYears * 100) / 80 );
        }
        else {
            return 0;
        }

        //Score by user's financial capacity, adding the new spend from this product
        try {
            $totalMonthlySpends = $client->getTotalMonthlySpends() + $this->getMonthlyFeeForGivenAmount($clientPreferences->getLoanAmount());
        } catch (ExceededLoanAmountException $exception) {
            // The requested amount is greater than the Product max amount, for instance, the product is incompatible
            return 0;
        }

        $percentage = round($totalMonthlySpends * 100 / $client->getNetMonthlyIncome(), 2);
        if ($percentage <= 40) {
            $score = 100 - $percentage;
        }
        else {
            return 0;
        }

        return (int)$score;
    }

    /**
     * @throws ExceededLoanAmountException
     * @param float $amount
     * @return float
     */
    public function getMonthlyFeeForGivenAmount(float $amount): float
    {
        if ($amount > $this->maxAmount) {
            throw new ExceededLoanAmountException();
        }
        $totalAmount = $amount + ($this->getInterestRate() / 100) * $amount;

        return round($totalAmount / 12, 2);
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
