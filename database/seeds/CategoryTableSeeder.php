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
            'former_id' => 91,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Arte y Narrativa',
            'slug' => 'arte-y-narrativa',
            'description' => '',
            'former_id' => 340,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Dinámicas y Juegos',
            'slug' => 'dinámicas-y-juegos',
            'description' => '',
            'former_id' => 29,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Estudios Bíblicos',
            'slug' => 'estudios-biblicos',
            'description' => '',
            'former_id' => 67,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Consejería',
            'slug' => 'consejeria',
            'description' => '',
            'former_id' => 27,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Cursos',
            'slug' => 'cursos',
            'description' => '',
            'former_id' => 160,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Libros',
            'slug' => 'libros',
            'description' => '',
            'former_id' => 29,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Reflexiones',
            'slug' => 'reflexiones',
            'description' => '',
            'former_id' => 341,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Tecnología',
            'slug' => 'tecnologia',
            'description' => '',
            'former_id' => null,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Artículos',
            'slug' => 'articulos',
            'description' => '',
            'former_id' => 71,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Música',
            'slug' => 'musica',
            'description' => '',
            'former_id' => null,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
          [
            'label' => 'Videos',
            'slug' => 'videos',
            'description' => '',
            'former_id' => null,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
          ],
        ]);
    }
}
