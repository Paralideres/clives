<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        DB::table('categories')->insert([
          [
            'label' => 'Devocionales',
            'slug' => 'devocionales',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Arte y Narrativa',
            'slug' => 'arte-y-narrativa',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Dinámicas y Juegos',
            'slug' => 'dinámicas-y-juegos',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Estudios Bíblicos',
            'slug' => 'estudios-biblicos',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Consejería',
            'slug' => 'consejeria',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Cursos',
            'slug' => 'cursos',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Libros',
            'slug' => 'libros',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Reflexiones',
            'slug' => 'reflexiones',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Tecnología',
            'slug' => 'tecnologia',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Artículos',
            'slug' => 'articulos',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Música',
            'slug' => 'musica',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Videos',
            'slug' => 'videos',
            'description' => '',
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
        ]);
    }
}
