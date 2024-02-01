<?php

namespace KMsalehi\LaravelEzCrud\Contracts;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ReflectionClass;

class ViewMaker
{
    private $modelName;
    private $fillable;
    private $pluralCamelModelName;
    private $camelModelName;
    private $pluralModelName;

    function makeViews(string $modelName, array $fillable): ?bool
    {
        if (($key = array_search('password', $fillable)) !== false) {
            unset($fillable[$key]);
        }
        $this->modelName = $modelName;
        $this->pluralCamelModelName = Str::camel(Str::plural($modelName));
        $this->pluralModelName = Str::plural($modelName);
        $this->camelModelName = Str::camel($this->modelName);

        $this->fillable = $fillable;

        $this->makeCreate();
        $this->makeEdit();
        $this->makeIndex();
        return true;
    }

    // create create.blade.php file
    function makeCreate()
    {
        $form = $this->makeCreateForm();

        $createContent = view(
            'ez-crud::create-stub',
            [
                'modelName' => $this->modelName,
                'form' => $form,
            ]
        )->render();
        $path = resource_path('views/' . $this->pluralCamelModelName . '/create.blade.php');

        $this->write($path, $createContent);
    }

    function makeEdit()
    {
        $form = $this->makeEditfrom();

        $editContent = view(
            'ez-crud::edit-stub',
            [
                'modelName' => $this->modelName,
                'form' => $form,
            ]
        )->render();
        $path = resource_path('views/' . $this->pluralCamelModelName . '/edit.blade.php');

        $this->write($path, $editContent);
    }

    function makeIndex()
    {
        $table = $this->makeIndexTable();
        $indexContent = view(
            'ez-crud::index-stub',
            [
                'modelName' => $this->modelName,
                'pluralCamelModelName' => $this->pluralCamelModelName,
                'table' => $table,
                'pluralModelName' => $this->pluralModelName,
            ]
        )->render();
        $path = resource_path('views/' . $this->pluralCamelModelName . '/index.blade.php');

        $this->write($path, $indexContent);
    }

    function makeIndexTable()
    {
        $fields = $this->fillable;
        $table = '<table class="table table-striped table-hover">
        <thead>
            <tr>';
        foreach ($fields as $field) {
            $table .= '<th scope="col">' . $field . '</th>';
        }
        $table .= '<th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($' . $this->pluralCamelModelName . ' as $' . $this->camelModelName . ')
            <tr>';
        foreach ($fields as $field) {
            $table .= '<td>{{ $' . $this->camelModelName . '->' . $field . ' }}</td>';
        }
        $table .= '<td>
                    <a href="{{ route(\'' . $this->pluralCamelModelName . '.edit\', $' . $this->camelModelName . ') }}" class="btn btn-sm btn-info">Edit</a>
                    <form action="{{ route(\'' . $this->pluralCamelModelName . '.destroy\', $' . $this->camelModelName . ') }}" method="POST" class="d-inline">
                        @csrf
                        @method(\'DELETE\')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>';
        return $table;
    }

    function makeCreateForm(): string
    {
        $fields = $this->fillable;
        // create form with bootstrap 5 and hold old values in inputs if validation fails
        $form = '<form action="{{ route(\'' . $this->pluralCamelModelName . '.store\') }}" method="POST">
        @csrf';
        foreach ($fields as $field) {
            $form .= '<div class="mb-3">
                <label for="' . $field . '">' . $field . '</label>
                <input type="text" name="' . $field . '" id="' . $field . '" class="form-control" placeholder="' . $field . '" value="{{ old(\'' . $field . '\') }}">
            </div>';
        }
        $form .= '<button type="submit" class="btn btn-primary">Save</button> </form>';
        return $form;
    }

    function makeEditfrom(): string
    {
        $fields = $this->fillable;
        // create form with bootstrap 5 and show current item data
        $form = '<form action="{{ route(\'' . $this->pluralCamelModelName . '.update\', $' . $this->camelModelName . ') }}" method="POST">
        @csrf
        @method(\'PUT\')';
        foreach ($fields as $field) {
            $form .= '<div class="mb-3">
                <label for="' . $field . '">' . $field . '</label>
                <input type="text" name="' . $field . '" id="' . $field . '" class="form-control" placeholder="' . $field . '" value="{{ $' . $this->camelModelName . '->' . $field . ' }}">
            </div>';
        }
        $form .= '<button type="submit" class="btn btn-primary">Save</button> </form>';
        return $form;
    }

    function write(string $path, string $content)
    {
        // check if path exists
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755);
        }

        file_put_contents($path, $content, LOCK_EX);
    }
}
