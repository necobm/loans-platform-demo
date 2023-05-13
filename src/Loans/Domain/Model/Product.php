<?php

namespace App\Loans\Domain\Model;

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
     * @ORM\Column(name="interest_rate", type="float", nullable=false)
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
     * @ORM\Column(name="max_amount", type="float", nullable=false)
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
     * @ORM\Column(name="minimal_income_requirement", type="float", nullable=true)
     */
    private float $minimalIncomeRequirement = 0;
    /**
     * @var float
     *
     * @ORM\Column(name="adicional_costs", type="float", nullable=true)
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
}
