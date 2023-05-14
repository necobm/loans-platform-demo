<?php

namespace App\Loans\Domain\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client
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
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=128, nullable=false)
     */
    private string $surname;
    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private int $age;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=false, unique=true)
     */
    private string $email;
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=256, nullable=false)
     */
    private string $city;
    /**
     * @var float
     *
     * @ORM\Column(name="net_monthly_income", type="float", precision=2, nullable=false)
     */
    private float $netMonthlyIncome;

    /**
     * @var float
     *
     * @ORM\Column(name="total_monthly_spends", type="float", precision=2, nullable=false)
     */
    private float $totalMonthlySpends;
    /**
     * @var ArrayCollection|Collection
     *
     * @ORM\OneToMany(targetEntity="ClientProduct", mappedBy="client")
     */
    private Collection|ArrayCollection $products;
    /**
     * @var ClientFinancialPreferences|null
     *
     * @ORM\OneToOne(targetEntity="ClientFinancialPreferences", mappedBy="client")
     */
    private ?ClientFinancialPreferences $financialPreferences;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }


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
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return float
     */
    public function getNetMonthlyIncome(): float
    {
        return $this->netMonthlyIncome;
    }

    /**
     * @param float $netMonthlyIncome
     */
    public function setNetMonthlyIncome(float $netMonthlyIncome): void
    {
        $this->netMonthlyIncome = $netMonthlyIncome;
    }

    /**
     * @return float
     */
    public function getTotalMonthlySpends(): float
    {
        $totalMonthlySpends = $this->totalMonthlySpends;
        $totalMonthlySpends += array_reduce($this->products->getValues(), function (float $sum, ClientProduct $up){
            if ($up->getStatus() === ClientProduct::STATUS_ACTIVE) {
                $sum += $up->getMonthlyFee();
                return $sum;
            }
            return 0;
        }, 0);

        return $totalMonthlySpends;
    }

    /**
     * @param float $totalMonthlySpends
     */
    public function setTotalMonthlySpends(float $totalMonthlySpends): void
    {
        $this->totalMonthlySpends = $totalMonthlySpends;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection $products
     */
    public function setProducts(ArrayCollection $products): void
    {
        $this->products = $products;
    }

    /**
     * @return ClientFinancialPreferences|null
     */
    public function getFinancialPreferences(): ?ClientFinancialPreferences
    {
        return $this->financialPreferences;
    }

    /**
     * @param ClientFinancialPreferences|null $financialPreferences
     */
    public function setFinancialPreferences(?ClientFinancialPreferences $financialPreferences): void
    {
        $this->financialPreferences = $financialPreferences;
    }

}
