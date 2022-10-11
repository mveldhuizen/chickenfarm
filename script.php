<?php
declare(strict_types = 1);

class Chicken {
    private string $identifier;
    private DateTimeImmutable $birthDate;
    private int $layedEggs = 0;
    private int $fertilizedEggs = 0;

    /**
     * @param string            $identifier
     * @param DateTimeImmutable $birthDate
     */
    public function __construct(string $identifier, DateTimeImmutable $birthDate)
    {
        $this->identifier = $identifier;
        $this->birthDate = $birthDate;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return int
     */
    public function getLayedEggs()
    {
        return $this->layedEggs;
    }

    /**
     * @return int
     */
    public function getFertilizedEggs()
    {
        return $this->fertilizedEggs;
    }

    /**
     * @return Egg[]
     * @throws Exception
     */
    public function layEggs(DateTimeImmutable $date): array
    {
        if ($this->canLayEggs($date)) {
            return [];
        }
        $fertilizable = true;
        if ($this->canFertilize($date)) {
            $fertilizable = false;
        }
        $amount = random_int(0, 2);
        if ($amount === 0) {
            return [];
        }
        $eggs = [];
        for ($x = 0; $x < $amount; $x++) {
            $egg = new Egg($fertilizable);
            $this->layedEggs++;
            if ($egg->isFertilized()) {
                $this->fertilizedEggs++;
            }
            $eggs[] = $egg;
        }
        return $eggs;
    }

    /**
     * @param DateTimeImmutable $date
     * @return bool
     */
    protected function canLayEggs(DateTimeImmutable $date): bool
    {
        return $date->diff($this->birthDate)->m < 4;
    }

    /**
     * @param DateTimeImmutable $date
     * @return bool
     */
    protected function canFertilize(DateTimeImmutable $date): bool
    {
        return $date->diff($this->birthDate)->m < 8;
    }
}

class Egg
{
    private bool $fertilized;

    /**
     * @param bool $fertilizable
     * @throws Exception
     */
    public function __construct(bool $fertilizable = true)
    {
        if (!$fertilizable) {
            $this->fertilized = false;
            return;
        }
        $this->fertilized = random_int(0, 1) === 1;
    }

    public function isFertilized(): bool
    {
        return $this->fertilized;
    }
}

class Farm
{
    /** @var Chicken[] */
    private array $chickens;
    private DateTimeImmutable $date;
    private int $uniqueIdentifier = 0;

    /**
     * @return void
     */
    public function addChicken(): void
    {
        $this->chickens[] = new Chicken($this->getIdentifier(), $this->date);
    }

    /**
     * @return string
     */
    private function getIdentifier(): string
    {
        return $this->date->format('Ymd') . '-' . $this->uniqueIdentifier++;
    }

    /**
     * @param DateTimeImmutable $date
     * @return void
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
        $this->uniqueIdentifier = 0;
    }

    /**
     * Simulate a day in the life of the farm, in which chickens lay eggs en possibly new chickens are born
     * @return void
     * @throws Exception
     */
    public function simulate(): void
    {
        foreach ($this->chickens as $chicken) {
            $eggs = $chicken->layEggs($this->date);
            foreach ($eggs as $egg) {
                if ($egg->isFertilized()) {
                    $this->addChicken();
                }
            }
        }
    }

    /**
     * Print the statistics of the farm
     * @return void
     */
    public function printStatistics(): void
    {
        $totalEggs = 0;
        $totalFertilizedEggs = 0;
        $topEggChicken = null;
        $topFertalizingChicken = null;
        foreach ($this->chickens as $chicken) {
            $totalEggs += $chicken->getLayedEggs();
            $totalFertilizedEggs += $chicken->getFertilizedEggs();
            if (is_null($topEggChicken)) {
                $topEggChicken = $chicken;
                $topFertalizingChicken = $chicken;
                continue;
            }
            if ($topEggChicken->getLayedEggs() < $chicken->getLayedEggs()) {
                $topEggChicken = $chicken;
            }
            if ($topFertalizingChicken->getFertilizedEggs() < $chicken->getFertilizedEggs()) {
                $topFertalizingChicken = $chicken;
            }
        }
        $salableEggs = $totalEggs - $totalFertilizedEggs;
        echo sprintf("Egg amount: %d \n", $totalEggs);
        echo sprintf("Fertilized egg amount: %d \n", $totalFertilizedEggs);
        echo sprintf("Salable egg amount: %d \n", $salableEggs);
        echo sprintf("Top egg chicken: %s (%d) \n", $topEggChicken->getIdentifier(), $topEggChicken->getLayedEggs());
        echo sprintf("Top fertalizing chicken: %s (%d) \n", $topFertalizingChicken->getIdentifier(), $topEggChicken->getFertilizedEggs());
        echo sprintf("Total revenue: €%.2f \n", round($salableEggs * 0.25, 2));
        echo sprintf("Total chickens born: %d \n", count($this->chickens)-50);
    }
}

$farm = new Farm();
$farm->setDate(new DateTimeImmutable('2021-04-01'));
for ($x = 0; $x < 50; $x++) {
    $farm->addChicken();
}
$date = new DateTimeImmutable('2022-01-01');
$farm->setDate($date);
for ($x = 0; $x < 365; $x++) {
    $farm->simulate();
    $date = $date->add(new DateInterval('P1D'));
    $farm->setDate($date);
}

$farm->printStatistics();