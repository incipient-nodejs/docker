<?php

    namespace Tests\Unit;

    use Tests\TestCase;
    use App\Services\BusinessDetailService;
    use App\Models\BusinessDetail;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    class BusinessDetailServiceTest extends TestCase
    {
        use RefreshDatabase;

        public function test_criacao_de_business_detail()
        {
            $service = new BusinessDetailService();
            $data = ['name' => 'Empresa Teste', 'user_id' => 1];

            $businessDetail = $service->create($data);

            $this->assertInstanceOf(BusinessDetail::class, $businessDetail);
            $this->assertDatabaseHas('business_details', ['name' => 'Empresa Teste']);
        }
    }

