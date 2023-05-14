<?php

namespace App\Loans\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_financial_preferences")
 */
class UserFinancialPreferences
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", inversedBy="financialPreferences")
     * @ORM\JoinColumn(name="client_id", nullable=false, unique=true)
     */
    private User $user;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
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
