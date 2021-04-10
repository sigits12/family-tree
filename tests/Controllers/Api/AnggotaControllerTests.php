<?php
    
namespace Tests\Controllers\Api;
    
use App\Models\Anggota;
use Illuminate\Http\Response;
use Tests\TestCase;
    
class AnggotaControllerTests extends TestCase {
    
    public function testIndexReturnsDataInValidFormat() {
    	$this->json('get', 'api/anggota')
         ->assertStatus(Response::HTTP_OK)
         ->assertJsonStructure(
         	[
         		'data' => [
         			'*' => [
         				'nama',
         				'jenis_kelamin',
         				'id_orang_tua'
         			]
                 ]
            ]
        );
  }

  public function testAnggotaIsCreatedSuccessfully() {
		$gender = $this->faker->randomElement(['L', 'P']);
		$payload = [
		    'nama' 			=>  $this->faker->unique()->name($gender),
		    'jenis_kelamin'	=>  $gender,
		    'id_orang_tua'	=>  "1"
		];

		$this->json('post', 'api/anggota', $payload)
			->assertStatus(Response::HTTP_CREATED)
			->assertJsonStructure(
				[
					'data' => [
						'nama',
		 				'jenis_kelamin',
		 				'id_orang_tua'
		 			]
		 		]
		 	);
		$this->assertDatabaseHas('anggota', $payload);
	}

	public function testAnggotaIsShownCorrectly() {
		$gender = $this->faker->randomElement(['L', 'P']);
	    $anggota = Anggota::create(
	        [
	            'nama' 			=>  $this->faker->unique()->name($gender),
			    'jenis_kelamin'	=>  $gender,
		    	'id_orang_tua'	=>  "1"
	        ]
	    );
	    $url = 'api/anggota/'.$anggota->id;
	    $this->json('get', $url)
	        ->assertStatus(Response::HTTP_OK)
	        ->assertExactJson(
	            [
	                'data' => [
	                    'id'			=> $anggota->id,
	                    'nama' 			=> $anggota->nama,
	                    'jenis_kelamin'	=> $anggota->jenis_kelamin,
	                    'id_orang_tua' 	=> $anggota->id_orang_tua
	                ]
	            ]
	        );
	}

	public function testAnggotaIsDestroyed() {
	    $gender = $this->faker->randomElement(['L', 'P']);
	    $payload = [
		    'nama' 			=>  $this->faker->unique()->name($gender),
		    'jenis_kelamin'	=>  $gender,
		    'id_orang_tua'	=>  "1"

		];
	    $anggota = Anggota::create($payload);
	    $url = 'api/anggota/'.$anggota->id;
	    $this->json('delete', $url)
	         ->assertNoContent();
	    $this->assertDatabaseMissing('anggota', $payload);
	}

	public function testUpdateAnggotaReturnsCorrectData() {
	    $gender = $this->faker->randomElement(['L', 'P']);
        $anggota = Anggota::create(
        	[
        		'nama' 			=>  $this->faker->unique()->name($gender),
			    'jenis_kelamin'	=>  $gender,
			    'id_orang_tua'		=>  1
	        ]
        );
        $payload = [
		    'nama' 			=>  $this->faker->unique()->name($gender),
		    'jenis_kelamin'	=>  $gender,
			'id_orang_tua'		=>  1
		];
	    $url = 'api/anggota/'.$anggota->id;
        $this->json('put', $url, $payload)
         ->assertStatus(Response::HTTP_OK)
         ->assertExactJson(
         	[
	            'data' => [
	                'id'			=> $anggota->id,
	                'nama' 			=> $payload['nama'],
	                'jenis_kelamin'	=> $payload['jenis_kelamin'],
	                'id_orang_tua' 	=> $payload['id_orang_tua']
	            ]
	        ]
	    );
    }
}