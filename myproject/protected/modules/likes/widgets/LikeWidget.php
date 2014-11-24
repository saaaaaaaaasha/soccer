<?php
    class LikeWidget extends CWidget{
        public $model;
        public $coutnlikes;
        
        public function init() {
            
        }
        
        public function run()
        {
           $this->coutnlikes = Likes::model()->like($this->model->id, get_class($this->model));
             $this->render('view', array('model'=> $this->model,'coutnlikes'=>$this->coutnlikes ));
        }
    }