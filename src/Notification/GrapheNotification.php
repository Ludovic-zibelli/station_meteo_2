<?php

namespace App\Notification;

use DateTime;

class GrapheNotification
{
    public function temperature($station)
    {




        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\LineChart();
        $data = [['Date', 'Temperature', 'Point de rosée']];
        foreach($station as $station_2)
        {
            $data[] = array(
                $station_2->getDateHeure(), $station_2->getTemperature(), (int)$station_2->getPointRosee()
            );
        }
        $chart->getData()->setArrayToDataTable($data);
        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()->setCurveType('function');
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
        $data = [['Date', 'Pression atmosphérique (hpa)']];
        foreach($station as $station_2)
        {
            $data[] = array(
                $station_2->getDateHeure(), $station_2->getPression()
            );
        }
        $chart->getData()->setArrayToDataTable($data);
        $chart->getOptions()->getVAxis()->setFormat('');
        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()->getHAxis()->getGridlines()->getUnits()->getHours()->setFormat('HH:mm');
        $chart->getOptions()->getHAxis()->getMinorGridlines()->getUnits()->getHours()->setFormat('HH:mm');
        $chart->getOptions()->setCurveType('function');
        $chart->getOptions()->getLegend()->setPosition('bottom');
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
        $data = [['Date', 'Humidité (%)']];
        foreach($station as $station_2)
        {
            $data[] = array(
                $station_2->getDateHeure(), $station_2->getHumiditer()
            );
        }
        $chart->getData()->setArrayToDataTable($data);
        $chart->getOptions()->getHAxis()->setFormat('d/M/yy HH:mm');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth('auto')
            ->setSeries([['axis' => 'Humidite ']])
            ->setAxes(['y' => ['Humidite' => ['label' => 'Humidité (%)']]]);
        return $chart;
    }
}