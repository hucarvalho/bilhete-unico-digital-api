<?php

    namespace App\Repositories\Eloquent;

    abstract class AbstractRepository
    {
        protected $model;
        public function __construct(){
            $this->model = $this->resolveModel();
        }
        public function defaultAll(){
            return $this->model->all();
        }
        public function resolveModel(){
            return app($this->model);
        }
        
        public function findById($id){
            return $this->model->find($id);
        }
        public function create($data){
            return $this->model->create($data);
        }
        public function destroy($id){
            return $this->model->destroy($id);
        }
        public function update($id, $data){
            $adm = $this->model->find($id);
            return $adm->update($data);
        }
    }