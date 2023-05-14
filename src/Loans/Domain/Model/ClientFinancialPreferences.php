<?php

namespace App\Loans\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_financial_preferences")
 */
class ClientFinancialPreferences
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
     * @var Client
     *
     * @ORM\OneToOne(targetEntity="Client", inversedBy="financialPreferences")
     * @ORM\JoinColumn(name="client_id", nullable=false, unique=true)
     */
    private Client $client;
    /**
     * @var ProductType
     *
     * @ORM\ManyToOne(targetEntity="ProductType")
     * @ORM\JoinColumn(name="product_type_id", nullable=false)
     */
    private ProductType $productType;
    /**
     * @var float
     *
     * @ORM\Column(name="loan_amount", type="float", nullable=false)
     */
    private float $loanAmount = 0;
    /**
     * @var int
     *
     * @ORM\Column(name="max_term", type="integer", nullable=false)
     */
    private int $maxTerm = 0;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * @return ProductType
     */
    public function getProductType(): ProductType
    {
        return $this->productType;
    }

    /**
     * @param ProductType $productType
     */
    public function setProductType(ProductType $productType): void
    {
        $this->productType = $productType;
    }

    /**
     * @return float
     */
    public function getLoanAmount(): float
    {
        return $this->loanAmount;
    }

    /**
     * @param float $loanAmount
     */
    public function setLoanAmount(float $loanAmount): void
    {
        $this->loanAmount = $loanAmount;
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


}
