<?php

namespace App\Loans\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_recommendation")
 */
class ProductRecommendation
{
    public const STATUS_CREATED = 'CREATED';
    public const STATUS_ACCEPTED = 'ACCEPTED';
    public const STATUS_REJECTED = 'REJECTED';

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="products")
     * @ORM\JoinColumn(name="client_id", nullable=false)
     */
    private User $user;
    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", nullable=false)
     */
    private Product $product;
    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private \DateTimeImmutable $dateCreated;
    /**
     * @var \DateTimeImmutable|null
     *
     * @ORM\Column(name="date_status_changed", type="datetime", nullable=true)
     */
    private ?\DateTimeImmutable $dateStatusChanged;
    /**
     * @var int
     *
     * @ORM\Column(name="interest_rate", type="integer", nullable=false)
     */
    private int $interestRate;
    /**
     * @var float
     *
     * @ORM\Column(name="monthly_fee", type="float", precision=2, nullable=false)
     */
    private float $monthlyFee;
    /**
     * @var int
     *
     * @ORM\Column(name="loan_term", type="integer", nullable=false)
     */
    private int $loanTerm;
    /**
     * @var float
     *
     * @ORM\Column(name="loan_amount", type="float", precision=2, nullable=false)
     */
    private float $loanAmount;
    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private string $status = self::STATUS_CREATED;

    public function __construct(
        User $user,
        Product $product
    )
    {
        $this->dateCreated = new \DateTimeImmutable();
        $this->setUser($user);
        $this->setProduct($product);
        $this->setInterestRate($product->getInterestRate());
        $this->setMonthlyFee(
            $product->getMonthlyFeeForGivenAmount($user->getFinancialPreferences()->getLoanAmount())
        );
        $this->setLoanAmount($user->getFinancialPreferences()->getLoanAmount());
        $this->setLoanTerm($user->getFinancialPreferences()->getMaxTerm());
    }

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
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDateCreated(): \DateTimeImmutable
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTimeImmutable $dateCreated
     */
    public function setDateCreated(\DateTimeImmutable $dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDateStatusChanged(): ?\DateTimeImmutable
    {
        return $this->dateStatusChanged;
    }

    /**
     * @param \DateTimeImmutable|null $dateStatusChanged
     */
    public function setDateStatusChanged(?\DateTimeImmutable $dateStatusChanged): void
    {
        $this->dateStatusChanged = $dateStatusChanged;
    }

    /**
     * @return int
     */
    public function getInterestRate(): int
    {
        return $this->interestRate;
    }

    /**
     * @param int $interestRate
     */
    public function setInterestRate(int $interestRate): void
    {
        $this->interestRate = $interestRate;
    }

    /**
     * @return float
     */
    public function getMonthlyFee(): float
    {
        return $this->monthlyFee;
    }

    /**
     * @param float $monthlyFee
     */
    public function setMonthlyFee(float $monthlyFee): void
    {
        $this->monthlyFee = $monthlyFee;
    }

    /**
     * @return int
     */
    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    /**
     * @param int $loanTerm
     */
    public function setLoanTerm(int $loanTerm): void
    {
        $this->loanTerm = $loanTerm;
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }



}
