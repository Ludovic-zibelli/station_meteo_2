<?php

namespace App\Tests\Notification;

use App\Entity\AlertMeteo;
use App\Notification\AlerteMeteoNotification;
use App\Notification\twitterNotification;
use App\Repository\AlertMeteoRepository;
use App\Repository\VigilanceMeteofranceRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class AlerteMeteoNotificationTest extends TestCase
{
    public function testDiscrepantTemperaturesDoNotTriggerOrClearAlert(): void
    {
        $repository = $this->createMock(AlertMeteoRepository::class);
        $repository->expects(self::never())->method('findByType');

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::never())->method('persist');
        $entityManager->expects(self::never())->method('flush');

        $notification = $this->createNotification($entityManager, $repository);

        $notification->calculAlerteTempAuto(0, 10);
        $notification->calculAlerteTempAuto(5, 10);
        $notification->calculAlerteTempAuto(null, 2);
    }

    public function testTemperatureDifferenceOfThreeDegreesStillAllowsAlert(): void
    {
        $activeAlert = (new AlertMeteo())->setOnline(false);
        $repository = $this->createMock(AlertMeteoRepository::class);
        $repository->expects(self::once())
            ->method('findByType')
            ->with(1)
            ->willReturn([$activeAlert]);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('persist');
        $entityManager->expects(self::once())->method('flush');

        $notification = $this->createNotification($entityManager, $repository);

        $notification->calculAlerteTempAuto(3, 6);
    }

    private function createNotification(
        EntityManagerInterface $entityManager,
        AlertMeteoRepository $repository
    ): AlerteMeteoNotification {
        return new AlerteMeteoNotification(
            $entityManager,
            $repository,
            $this->createMock(twitterNotification::class),
            $this->createMock(VigilanceMeteofranceRepository::class)
        );
    }
}
