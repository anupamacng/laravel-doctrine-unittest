<?php

 namespace Joselfonseca\LaravelAdminRest\Services\Users\Transformers;
     
     
    use League\Fractal;
    use App\Entity\Department;
    /**
     * Description of UserTransformer
     *
     * @author josefonseca
     */
    class DepartmentTransformer extends Fractal\TransformerAbstract
    {
        public function transform(Department $user)
        {
            return [
                'id' => (int) $user->id,
                'name' => $user->emp_name,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at
            ];
        }
    }