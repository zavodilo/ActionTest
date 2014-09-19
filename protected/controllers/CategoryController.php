<?php

class CategoryController extends Controller
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
				'actions'=>array('index','view', 'list','viewTags'),
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
		
		//список товаров в категории
		$query = "select product_to_category.product_id, product.name from product_to_category, product where product_to_category.product_id=product.id AND product.active=1 AND product_to_category.category_id=".$id;
		$modelProduct = Yii::app()->db->createCommand($query)->queryAll();
        $listProduct = CHtml::listData($modelProduct, 
                'product_id', 'name', 'category_id');
                
        //список всех товаров с категориями   
        $query = "select product_to_category.product_id, product_to_category.category_id, category.name from product_to_category, category where product_to_category.category_id=category.id  AND category.active=1";
		$modelCategory = Yii::app()->db->createCommand($query)->queryAll();
        $listCategory = CHtml::listData($modelCategory, 
                 'category_id','name','product_id');  
                
        //список всех товаров с тегами
        $query = "select product_to_tag.product_id, product_to_tag.tag_id, tag.name from product_to_tag, tag where product_to_tag.tag_id=tag.id AND tag.active=1";
		$modelTags = Yii::app()->db->createCommand($query)->queryAll();
        $listTags = CHtml::listData($modelTags, 
                 'tag_id','name','product_id');
                 
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'listProduct'=>$listProduct,
			'listCategory'=>$listCategory,
			'listTags'=>$listTags,
		));
		
	}
	
		public function actionViewTags($id)
	{
		//не активные страницы не выводим в соответствии с заданием
		if($this->loadModel($id)->active!=1){
			throw new CHttpException(404, Yii::t('base', 'Страница не активна.'));
		}
		
		//список товаров в категории
		$query = "SELECT tag.id, tag.name
					FROM product_to_category, tag, product_to_tag, product
					WHERE product_to_category.product_id = product_to_tag.product_id
					AND product_to_tag.tag_id = tag.id
					AND product_to_category.category_id =".$id."
					AND product.active =1
					AND tag.active =1
					GROUP BY tag.id";
		$modelTags = Yii::app()->db->createCommand($query)->queryAll();
        $listTags = CHtml::listData($modelTags, 
                'id', 'name');
       
		$query = "SELECT *FROM tag WHERE id NOT IN(SELECT tag.id
					FROM product_to_category, tag, product_to_tag, product
					WHERE product_to_category.product_id = product_to_tag.product_id
					AND product_to_tag.tag_id = tag.id
					AND product_to_category.category_id =".$id."
					AND product.active =1)
					AND tag.active =1
					GROUP BY tag.id";
		$modelNoTags = Yii::app()->db->createCommand($query)->queryAll();
        $listNoTags = CHtml::listData($modelNoTags, 
                'id', 'name');                 
		$this->render('view_tags',array(
			'model'=>$this->loadModel($id),
			'listTags'=>$listTags,
			'listNoTags'=>$listNoTags,
		));
		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
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

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
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
		$dataProvider=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
    public function actionList()
    {
		$query = "select product_to_category.product_id, product_to_category.category_id, product.name from product_to_category, product where product_to_category.product_id=product.id AND product.active=1";
		$modelProduct = Yii::app()->db->createCommand($query)->queryAll();
        $listProduct = CHtml::listData($modelProduct, 
                'product_id', 'name', 'category_id'); 
        $query = "SELECT * FROM category where category.active=1";           
        $modelCategory= Yii::app()->db->createCommand($query)->queryAll();
        $listCategory = CHtml::listData($modelCategory, 
                'id', 'name');
        $this->render('list',array(
			'listCategory'=>$listCategory,
			'listProduct'=>$listProduct,
		));		
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
