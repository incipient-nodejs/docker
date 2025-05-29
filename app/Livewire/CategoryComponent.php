<?php

namespace App\Livewire;

use App\Services\CategoryService;
use App\Models\Category;
use Livewire\Component;

class CategoryComponent extends Component
{
    private $categoryService;

    public $search = '';

    public $uuid = '';
    public $name = '';
    public $code = '';
    public $type = '';

    public function __construct(){
        $this->categoryService = new CategoryService();
    }

    public function render()
    {
        return view('livewire.category-component', [
            'categories' => $this->categoryService->paginate()
        ]);
    }
    public function request(){
        dd($this->uuid, $this->name, $this->code, $this->type);
        if($this->uuid == '')
            return $this->store();
        else
            return $this->update();
    }

    private function store(){
        try{
            $this->categoryService->create([
                'name' => $this->name,
                'code' => $this->code,
                'type' => $this->type,
            ]);
            toastr()->success('Criado com successo');
        }catch(\Exception){
            toastr()->error('Erro na operação');
        }finally{
            return redirect()->route('categories.view');
        }
    }

    private function update(){
        try{
            $this->categoryService->update([
                'name' => $this->name,
                'code' => $this->code,
                'type' => $this->type,
            ], $this->uuid);
            toastr()->success('Editado com successo');
        }catch(\Exception){
            toastr()->error('Erro na operação');
        }finally{
            return redirect()->route('categories.view');
        }
    }

    /** Methods   */

    public function prepareCreate()
    {

        $this->uuid = '';
        $this->name = '';
        $this->code = '';
        $this->type = '';

        $this->dispatch('open-modal');
    }

    public function edit($uuid)
    {
        $category = $this->categoryService->findByUuid($uuid);

        $this->name = $category->name;
        $this->code = $category->code;
        $this->type = $category->type;
        $this->uuid = $uuid ;

        $this->dispatch('open-modal', category: $category) ;
    }

}
