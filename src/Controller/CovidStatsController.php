<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\CallApiService;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Date;
use DateTime;


class CovidStatsController extends AbstractController
{
	

    /**
     * @Route("/", name="covid_stats")
     */

    #Route("/covid/stats", name="covid_stats")
    public function index( CallApiService $callApiService,ChartBuilderInterface $chartBuilder ): Response
    {

		 $date      = [];    //LABELS
		 $confirmed = [];    //DATASET
		 $deaths    = [];	 //DATASET
		 $recovered = [];	 //DATASET
		 $active    = [];	 //DATASET

		 $datas = $callApiService->get_sa_data();

		 foreach ( $datas as $data ) {

		 	$date_time    = New DateTime( $data["Date"] );
		 	$date[] 	  = $date_time->format('Y-m-d');
		 	$confirmed[]  = $data["Confirmed"];
		 	$deaths[]	  = $data["Deaths"];
		 	$recovered[]  = $data["Recovered"];
		 	$active[]	  = $data["Active"];

		 }


		 $chart = $chartBuilder->createChart( Chart::TYPE_LINE );
		 $chart->setData([
		 		
		 		'labels'   => $date ,
		 		'datasets' => [
		 			[
		 				'label' => 'Confirmed',
                    	 #BLUE
                    	'borderColor' => '#0069D9',
                    	'data' => $confirmed,
		 			],
		 			[
		 				'label' => 'Deaths',
                         #RED
                    	'borderColor' => '#C82333',
                    	'data' => $deaths,
		 			],
		 			[
		 				'label' => 'Recovered',
                    	 #GREEN
                    	'borderColor' => '#218838',
                    	'data' => $recovered,
		 			],
		 			[
		 				'label' => 'Active',
                    	 #YELLOW
                    	'borderColor' => '#E0A800',
                    	'data' => $active,
		 			],


		 		],

		]);

		$chart->setOptions([/* ... */]);

        return $this->render('covid_stats/index.html.twig', [
            'chart' => $chart,
        ]);


    }
}
