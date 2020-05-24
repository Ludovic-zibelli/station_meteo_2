<?php

namespace App\Notification;

use DateTime;

class GrapheNotification
{
    public function temperature($station)
    {
        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart();
        $chart->getData()->setArrayToDataTable([
            ['Date', 'Temperature' , 'Point de rosée'],
            [$station[0]->getDateHeure(),  $station[0]->getTemperature(), (int)$station[0]->getPointRosee()],
            [$station[1]->getDateHeure(),  $station[1]->getTemperature(), (int)$station[1]->getPointRosee()],
            [$station[2]->getDateHeure(),  $station[2]->getTemperature(), (int)$station[2]->getPointRosee()],
            [$station[3]->getDateHeure(),  $station[3]->getTemperature(), (int)$station[3]->getPointRosee()],
            //[$station[4]->getDateHeure(),  $station[4]->getTemperature(), (int)$station[4]->getPointRosee()],
        ]);

        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Temperature'], ['axis' => 'ptro']])
            ->setAxes(['y' => ['Temperature' => ['label' => 'Température (C°)'], 'ptro' => ['label' => 'Point de rosée']]]);
        return $chart;
    }

    public function pression($station)
    {

        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart();
        $chart->getData()->setArrayToDataTable([
            ['Date', 'Pression atmosphérique (hpa)' ],
            [$station[0]->getDateHeure(),  $station[0]->getPression()],
            [$station[1]->getDateHeure(),  $station[1]->getPression()],
            [$station[2]->getDateHeure(),  $station[2]->getPression()],
            [$station[3]->getDateHeure(),  $station[3]->getPression()],
            //[$station[4]->getDateHeure(),  $station[4]->getTemperature(), (int)$station[4]->getPointRosee()],
        ]);

        $chart->getOptions()->getVAxis()->setFormat('');
        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()->getHAxis()->getGridlines()->getUnits()->getHours()->setFormat('HH:mm');
        $chart->getOptions()->getHAxis()->getMinorGridlines()->getUnits()->getHours()->setFormat('HH:mm');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Pression']])
            ->setAxes(['y' => ['Pression' => ['label' => 'Pression atmosphérique (hpa)']]]);
        return $chart;

    }

    public function humidite($station)
    {
        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart();
        $chart->getData()->setArrayToDataTable([
            ['Date', 'Humidité (%)' ],
            [$station[0]->getDateHeure(),  $station[0]->getHumiditer()],
            [$station[1]->getDateHeure(),  $station[1]->getHumiditer()],
            [$station[2]->getDateHeure(),  $station[2]->getHumiditer()],
            [$station[3]->getDateHeure(),  $station[3]->getHumiditer()],
            //[$station[4]->getDateHeure(),  $station[4]->getTemperature(), (int)$station[4]->getPointRosee()],
        ]);
        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Humidite ']])
            ->setAxes(['y' => ['Humidite' => ['label' => 'Humidité (%)']]]);
        return $chart;
    }
}