<?php

return [
    'admin' => [
        'title' => 'Mini E-commerce',
        'table' => [
            'name' => 'Nom',
            'price' => 'Prix',
            'categories' => 'Catégories',
            'description' => 'Description',
            'action' => 'Action',
        ],
        
        'form' => [
            'title' => 'Ajouter un nouveau produit',
            'name_label' => 'Nom du produit',
            'name_placeholder' => 'Entrez le nom du produit',
            'price_label' => 'Prix du produit',
            'price_placeholder' => 'Entrez le prix du produit',
            'image_label' => 'Aperçu de l\'image',
            'category_label' => 'Catégorie du produit',
            'description_label' => 'Description du produit',
            'description_placeholder' => 'Entrez la description du produit',
            'file_size_limit' => 'La taille maximale du fichier est de 2 Mo',
        ],
    ],
];
