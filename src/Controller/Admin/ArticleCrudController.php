<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use App\Form\Field\CKEditorField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            //->addFormTheme('@FMElfinder/Form/elfinder_widget.html.twig')
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ->addFormTheme('@FMElfinder/Form/elfinder_widget.html.twig')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title');
        yield SlugField::new('slug')->setTargetFieldName('title');
        yield CKEditorField::new('content', 'Contenu');
                //->setFormType(CKEditorType::class);
        yield AssociationField::new('categories');
        yield TextField::new('featuredText');
        yield AssociationField::new("featuredImageId");
        //yield CKEditorField::new("image");
        // ...
        yield Field::new('image', 'Image')
        ->setFormType(ElFinderType::class)
        ->setFormTypeOptions([
            'instance' => 'default',
            'enable' => true,
        ])
        ->onlyOnForms();
        
        yield DateTimeField::new('createdAt')->hideOnForm();
        yield DateTimeField::new('updateAt')->hideOnForm();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('categories'))
        ;
    }

    
}
