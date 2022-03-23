<?php

namespace App\Controller\Admin;

use App\Entity\Cards;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CardsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cards::class;
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
