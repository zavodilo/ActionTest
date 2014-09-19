<?php

class TagController extends Controller
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
				'actions'=>array('index','view','all'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
		//не активные страницы не выводим в соответствии с заданием
		if($this->loadModel($id)->active!=1){
			throw new CHttpException(404, Yii::t('base', 'Страница не активна.'));
		}
		
		//список всех товаров по тегу
        $query = "select product_to_tag.product_id, product.name from product_to_tag, product where product_to_tag.product_id=product.id AND product.active=1 AND product_to_tag.tag_id=".$id;
		$modelTags = Yii::app()->db->createCommand($query)->queryAll();
        $listTags = CHtml::listData($modelTags, 
                 'product_id','name');
		//print_r($listTags);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'listTags'=>$listTags,
		));
	}
	
	public function actionAll()
	{
		//создать облако тегов
		$query = "SELECT tag.name, tag.id, COUNT( product_to_tag.tag_id )
		FROM product_to_tag, product, tag
		WHERE product.id = product_to_tag.product_id
		AND product_to_tag.tag_id = tag.id
		AND product.active =1
		AND tag.active =1
		GROUP BY product_to_tag.tag_id
		ORDER BY COUNT( product_to_tag.tag_id ) DESC";
		$modelAllTagsCounts = Yii::app()->db->createCommand($query)->queryAll();		
		$min_real = 8;  //--Минимальный размер тега (8pt)
		$max_real = 22; //--Максимальный размер тега (22pt)
		$min_db = 100000;
		$max_db = 0;
		//необходимо определить минимальное и максимальное значение
		foreach ($modelAllTagsCounts as $tag)
		{
			$min_db = min($min_db, $tag['COUNT( product_to_tag.tag_id )']);
			$max_db = max($max_db, $tag['COUNT( product_to_tag.tag_id )']);
		}
		foreach ($modelAllTagsCounts as $key=> $tag)
		{
			//расчитаем размер тега
			$modelAllTagsCounts[$key]['size']=(($tag['COUNT( product_to_tag.tag_id )'] - $min_db) / ($max_db - $min_db) * ($max_real - $min_real) + $min_real );			
		}
		//print_r($modelAllTagsCounts);
		
		$this->render('all',array(
			'listAllTagsCounts'=>$modelAllTagsCounts,	
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Tag;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Tag']))
		{
			$model->attributes=$_POST['Tag'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Tag');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Tag('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Tag']))
			$model->attributes=$_GET['Tag'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Tag the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Tag::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Tag $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tag-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
