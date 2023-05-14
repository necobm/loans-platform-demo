<?php

namespace App\Loans\Domain\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_product")
 */
class ClientProduct
{
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_IN_REVISION = 'IN_REVISION';
    public const STATUS_FINISHED = 'FINISHED';

    /**
     * @var int|null
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?int $id = null;
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="products")
     * @ORM\JoinColumn(name="client_id", nullable=false)
     */
    private Client $client;
    /**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", nullable=false)
     */
    private Product $product;
    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     */
    private \DateTimeInterface $startDate;
    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private \DateTimeInterface $endDate;
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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=20, nullable=false)
     */
    private string $status = self::STATUS_IN_REVISION;

    public function __construct(
        ProductRecommendation $productRecommendation
    )
    {
        $this->setClient($productRecommendation->getClient());
        $this->setProduct($productRecommendation->getProduct());
        $this->setStartDate(new \DateTimeImmutable());
        $this->setEndDate(
            $this->startDate->add(
                new \DateInterval('P'. $productRecommendation->getLoanTerm() .'Y')
            )
        );
        $this->setInterestRate($productRecommendation->getInterestRate());
        $this->setMonthlyFee($productRecommendation->getMonthlyFee());
        $this->setStatus(self::STATUS_ACTIVE);
    }


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
     * @return \DateTimeInterface
     */
    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     */
    public function setStartDate(\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     */
    public function setEndDate(\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
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
