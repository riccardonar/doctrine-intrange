Doctrine In4Range Type
==========================

Thanks to @Salamek, this is an adapt to https://github.com/Salamek/doctrine-daterange

Supports PostgreSQL DateRange in Doctrine DBAL.

Summary
-------

The `IntRange` library

- adds a `intrange` type to DBAL

Installation
------------

Add it to your list of Composer dependencies:

```sh
composer require riccardonar/doctrine-intrange
```

Register it with Doctrine DBAL:

```php
<?php

use Doctrine\DBAL\Types\Type;
use riccardonar\Doctrine\DBAL\Types\IntRangeType;

Type::addType(
    IntRangeType::INTRANGE,
    'riccardonar\\Doctrine\\DBAL\\Types\\IntRangeType'
);
```

When using Symfony2 with Doctrine you can do the same as above by only changing your configuration:

```yaml
# app/config/config.yml

# Doctrine Configuration
doctrine:
    dbal:
        # ...
        mapping_types:
            intrange: intrange
        types:
            intrange:  riccardonar\Doctrine\DBAL\Types\IntRangeType
```

Usage
-----

```php
<?php

/**
 * @Entity()
 * @Table(name="jobs")
 */
class Job
{
    /**
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @Id()
     */
    private $id;

    /**
     * @Column(type="intrange")
     */
    private $range;

    /**
     * @return integer[]
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param integer[] $range
     */
    public function setRange(array $range)
    {
        $this->range = $range;
    }
}

$annualJob = new Job();
$annualJob->setRange(new \Salamek\DateRange(new \DateTime, (new \DateTime)->modify('+1 year')));

$entityManager->persist($annualJob);
$entityManager->flush();
$entityManager->clear();

$jobs = $entityManager->createQuery(
    "SELECT j FROM Jobs j"
)->getResult();

echo $jobs[0]->getRange()->getStartDate()->format(DateTime::ISO8601); // "NOW"
echo $jobs[0]->getRange()->getEndDate()->format(DateTime::ISO8601); //  "NOW +1 year"
```
