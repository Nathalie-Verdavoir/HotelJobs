<?php

namespace App\Controller\Admin;

use App\Entity\Postulant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostulantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Postulant::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
