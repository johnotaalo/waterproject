<?php

namespace Pims\Evaluation\Controllers;

use Pims\Common\Controllers\BaseController;

use Pims\Common\Models\UnepDivisions;
use Pims\Evaluation\Models\EvaluationRanking;
use Pims\Evaluation\Models\Section;
use Pims\Evaluation\Models\SectionRanking;

class AnalyticsController extends BaseController
{

	function indexAction()
	{
		// $this->view->disable();
		$this->view->content = $this->view
										->setVars([
												'bienium_select'	=>	$this->createBieniumSelect(),
												'sections_select'	=>	$this->createSectionsSelect()
											])
										->getPartial('analytics/index');

		$chart_data = $this->getGeneralEvaluationData();

		// echo "<pre>";print_r($chart_data);die;

		$this->assets
				->addCss('plugins/loaders/facebook.css');
				
		$this->assets
				->addJs('plugins/Highcharts/js/highcharts.js')
				->addJs('https://code.highcharts.com/modules/exporting.js', true);
		$custom_js = [
			'partial'=>'analytics_js', 
			'params'=> [
				'chart_data'	=>	$chart_data
			]
		];
		

		$this->addJavaScript($custom_js);
	}

	function createBieniumSelect()
	{
		$all_bieniums = EvaluationRanking::getAllBienia();

		$select = "";
		foreach ($all_bieniums as $bienium) {
			$select .= "<option value = '{$bienium->bienium}'>{$bienium->bienium}</option>";
		}

		// echo $select;die;
		return $select;
	}

	function createSectionsSelect()
	{
		$all_sections = Section::find();

		$sections_select = "<option value = 'NULL'>All sections</option>";

		foreach ($all_sections as $section) {
			$sections_select .= "<option value = '{$section->id}'>{$section->section}</option>";
		}

		return $sections_select;
	}

	function getGeneralEvaluationData()
	{
		$response = array();
		$all_sections = Section::find();

		$rankings = EvaluationRanking::find();
		// creating an array from the rankings is_object

		$rankings_arr = [];

		foreach ($rankings as $ranking) {
			$rankings_arr[] = $ranking->ranking;
		}

		$sample_array = [];
		$sections = [];

		foreach ($all_sections as $section) {
			$sections[] = $section->section;
			$ranking_count = EvaluationRanking::getRankingCountBySectionId($section->id);

			foreach ($ranking_count as $count) {
				$sample_array[$count->ranking][] = $count->totals;
			}
		}

		$response['sections'] = json_encode($sections);

		$final_arr = array();
		foreach ($sample_array as $key => $arr) {
			$final_arr[] = [
				"name"	=>	$key,
				"data"	=>	$arr
			];
		}

		$series_str = json_encode($final_arr, JSON_NUMERIC_CHECK);
		$series_str = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $series_str);
		

		$response['series'] = $series_str;

		return $response;
	}

	function generateFilteredDataChartAction($bienium = NULL, $section = NULL)
	{
		if ($this->request->isAjax()) {
			$bienium =str_replace('-', '/', $bienium);

			$bienium = ($bienium == "unspecified") ? NULL : $bienium;

			$checks_arr = ['bienium'];

			$all_sections = Section::find();

			$rankings = EvaluationRanking::find();
			// creating an array from the rankings is_object

			$rankings_color = [];

			foreach ($rankings as $ranking) {
				$rankings_color[$ranking->ranking] = $ranking->color;
			}

			$sample_array = [];
			$sections = [];

			foreach ($all_sections as $section) {
				$sections[] = $section->section;
				$ranking_count = EvaluationRanking::getRankingCountBySectionId($section->id, $bienium, $section);

				foreach ($ranking_count as $count) {
					$sample_array[$count->ranking][] = $count->totals;
				}
			}

			$response['sections'] = json_encode($sections);

			$final_arr = array();
			foreach ($sample_array as $key => $arr) {
				$final_arr[] = [
					"name"	=>	$key,
					"data"	=>	$arr,
					"color"	=>	$rankings_color[$key]
				];
			}

			$series_str = json_encode($final_arr, JSON_NUMERIC_CHECK);

			echo $series_str;die;
			$series_str = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $series_str);

			$response['series'] = $series_str;
			$this->view->disable();

			return $this->response->setJsonContent($response);
		}else{
			echo "Nothing here";
		}
	}

	function getDataBySectionAction($section)
	{
		$this->view->disable();
		$rankings = EvaluationRanking::getSectionRankingByYears($section);
		$evaluation_rankings = EvaluationRanking::find();

		$series_data = $categories = [];
		$data = [];
		foreach ($rankings as $ranking) {
			$categories[] = $ranking->YEAR;
			$ranking_arr = (array)$ranking;
			
			foreach ($evaluation_rankings as $eval_ranking) {
				$data[$eval_ranking->ranking][] = $ranking_arr[$eval_ranking->ranking];
			}

		}


		foreach ($data as $key => $value) {
			$series_data[] = [
				'name'		=>	$key,
				'data'		=>	$value
			];
		}

		$response = [];

		$response = [
			'categories'	=>	$categories,
			'series'		=>	$series_data
		];

		$this->response->setContentType('application/json', 'UTF-8');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}

	function getSubProgrammeDataAction($section_id)
	{
		$this->view->disable();

		$sub_programmes =  EvaluationRanking::getSubProgrammes();
		$rankings = EvaluationRanking::find();

		$categories = $response = [];

		if (count($sub_programmes)) {
			foreach ($sub_programmes as $sub_programme) {
				$categories[] = $sub_programme->sp_name;
			}
		}

		$series = $series_data = [];
		$counter = 0;
		foreach ($rankings as $ranking) {
			$series_data[$counter]  = ['name'	=>	$ranking->ranking];
			foreach ($sub_programmes as $sub_programme) {
				$data = EvaluationRanking::getSubProgrammeData($section_id, $ranking->id, $sub_programme->sp_number);
				$series_data[$counter]['data'][] = $data->NUMBER;
			}

			$counter++;
		}

		$response = [
			'categories'	=>	$categories,
			'series'		=>	$series_data
		];

		$this->response->setContentType('application/json', 'UTF-8');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
	
	function getDivisionsDataAction($section_id)
	{
		$this->view->disable();
		// Getting all divisions
		$divisions = UnepDivisions::find();

		// Getting the rankings
		$rankings = EvaluationRanking::find();

		$categories = [];

		if (count($divisions)) {
			foreach ($divisions as $key => $value) {
				$categories[] = $value->acronym;
			}
		}

		$counter = 0;
		$series_data = [];
		foreach ($rankings as $ranking) {
			$series_data[$counter]  = ['name'	=>	$ranking->ranking];
			foreach ($divisions as $division) {

				$division_name = "{$division->name}({$division->acronym})";
				$data = EvaluationRanking::getDivisionData($section_id, $ranking->id, $division_name);
				$series_data[$counter]['data'][] = $data->number;
			}

			$counter++;
		}

		$response = [
			'categories'	=>	$categories,
			'series'		=>	$series_data
		];

		$this->response->setContentType('application/json', 'UTF-8');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}

	function getReportRatingsAction()
	{
		$this->view->disable();

		$rankings = EvaluationRanking::find();

		$categories = $series_data = []; 
		foreach ($rankings as $ranking) {
			$categories[] = $ranking->ranking;
		}

		$report_ratings = EvaluationRanking::getReportRatings();

		foreach ($report_ratings as $rating) {
			$series_data[] = [
				"name"	=>	$rating->ranking,
				"data"	=>	[
					0	=>	$rating->draft_report,
					1	=>	$rating->final_rating
				]
			];
		}

		$response = [
			'categories'	=>	$categories,
			'series'		=>	$series_data
		];

		$this->response->setContentType('application/json', 'UTF-8');
		echo json_encode($response, JSON_NUMERIC_CHECK);
	}
}