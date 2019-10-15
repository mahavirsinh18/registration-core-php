<?php
class StudentController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','loadstates','loadcities','generatePDF','generateexcel'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Student;
		$model2=new Department;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation(array($model,$model2));
		if(isset($_POST['Student']) && $_POST['Department'] != "")
		{	
			/*echo "<pre>";
			print_r($_POST);
			die();*/
			
			$model->attributes=$_POST['Student'];						
			$profile=CUploadedFile::getInstance($model,'profile');
			if($profile)
			{
				$rand = rand(0,9999).$profile->name;
				$model->profile=$rand;
			}
			if($model->save())
			{
				$model2->attributes=$_POST['Department'];
				$model2->user_id=$model->id;
				$model2->save();
				$profile->saveAs(Yii::app()->basePath .'/../uploads/' . $model->profile);
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('create',array(
			'model'=>$model,
			'model2'=>$model2,
		));
	}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model2 = Department::model()->findByAttributes(array('user_id'=>$model->id));
		$oldImage = $model->profile;
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		if(isset($_POST['Student']) && $_POST['Department'] != "")
		{
			/*echo "<pre>";
			print_r($_POST);
			die();*/
			$model->attributes=$_POST['Student'];
			$profile=CUploadedFile::getInstance($model,'profile');
			if($profile != "")
			{
				$rand = rand(0,9999).$profile->name;
				$model->profile=$rand;
			}
			else
			{
				$model->profile = $oldImage;
			}
			if($model->save())
			{
				if($profile != "")
				{
					$model2->attributes=$_POST['Department'];
					$model2->user_id=$model->id;
					$model2->save();
					$profile->saveAs(Yii::app()->basePath .'/../uploads/' . $model->profile);
					if(file_exists(Yii::app()->basePath.'/..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$oldImage))
					{
						unlink(Yii::app()->basePath.'/../uploads/'.$oldImage);
					}					
				}
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'model2'=>$model2,
		));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = Student::model()->find(array("condition"=>"id =  $id"));
		$model2 = Department::model()->find(array("condition"=>"user_id =  $id"));
		unlink(Yii::app()->basePath.'/../uploads/'.$model->profile);
		$this->loadModel($id)->delete();
		$model2->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	public function actionLoadstates()
	{
		$data=State::model()->findAll('country_id=:country_id', 
		array(':country_id'=>(int) $_POST['country_id']));
		$data=CHtml::listData($data,'id','state_name');
		echo "<option value=''>State</option>";
		foreach($data as $value=>$statename)
		echo CHtml::tag('option', array('value'=>$value),CHtml::encode($statename),true);
	}
	public function actionLoadcities()
	{
		$data=City::model()->findAll('state_id=:state_id',
		array(':state_id'=>(int) $_POST['state_id']));
		$data=CHtml::listData($data,'id','city_name');
		echo "<option value=''>City</option>";
		foreach($data as $value=>$cityname)
		echo CHtml::tag('option', array('value'=>$value),CHtml::encode($cityname),true);
	}
	// public function actionGeneratePDF()
	// {
	//     $model = Student::model()->findAll();
	//    /* echo "<pre>";
	//     print_r($model);
	//     die();*/
	//     $mpdf1 = Yii::app()->ePdf->mpdf();
	//     $myhtml=$this->renderPartial('admin', array(
	//         'personal_info'=>$model), true);
	//     $mpdf1->WriteHTML($myhtml);
	//     $file_name= $id.'.pdf';
	//     ob_end_clean();
	//     $mpdf1->Output($file_name,EYiiPdf::OUTPUT_TO_DOWNLOAD );
	// }
	public function actionGenerateExcel()
	{
		$phpExcelPath =yii::app()->basePath.'./vendor/PHPExcel-1.8/Classes/';
   		require_once($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');	

 		$objPHPExcel = new PHPExcel();
 		$objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);
		$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'NAME')
                    ->setCellValue('B1', 'EMAIL')
                    ->setCellValue('C1', 'PASSWORD')
                    ->setCellValue('D1', 'GENDER')
                    ->setCellValue('E1', 'MOBILE')
                    ->setCellValue('F1', 'COUNTRY')
                    ->setCellValue('G1', 'STATE')
                    ->setCellValue('H1', 'CITY')
                    ->setCellValue('I1', 'DEPARTMENT')		

		$post_list = array();

		$search_value = Yii::app()->session['Export_data'];
		$row = Student::model()->findAll($search_value->criteria);

		foreach($row as $key => $value)
		{
			$country = Country::model()->findByPk($value['country']);
			$state = State::model()->findByPk($value['state']);
			$city = City::model()->findByPk($value['city']);
			$department = Department::model()->find('user_id='.$value['id']);

			$post_list[] = array("ID"=>$value["id"],"Name"=>$value["name"],"Email"=>$value["email"],"Password"=>$value["password"],"Gender"=>$value["gender"],"Mobile"=>$value["mobile"],"Country"=>$country['country_name'],"State"=>$state["state_name"],"City"=>$city["city_name"],"Department"=>$department["department_name"]);
		}

		$rowCount = 2;
		foreach($post_list as $post) {    
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount,$post['Name']);
			$objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,$post['Email']);
			$objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,$post['Password']);
			$objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,$post['Gender']);
			$objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount,$post['Mobile']);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,$post['Country']);
			$objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$post['State']);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount,$post['City']);
			$objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,$post['Department']);
			$rowCount++;
		}

		header('Content-Type: application/vnd.ms-excel');				
		$filename="EmployeeDetail";
		header('Content-Disposition: attachment;filename='.$filename.'.xls');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Cache-Control: cache, must-revalidate');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Student');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Student('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Student']))
			$model->attributes=$_GET['Student'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Student the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Student::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param Student $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}