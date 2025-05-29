<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public const PRODUCTS = [
        [
            'name' => 'Smartphone iPhone 14 Pro',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/41/fa/34/90/24/v1_E10/E10286TD.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=d033c93b0e332a50e6841e7e563eb15f9b87885830b652d8dc335013de7f5077',
            'video' => 'https://example.com/videos/iphone14pro.mp4',
            'description' => 'iPhone 14 Pro com processador A16 Bionic, câmera tripla de 48MP e tela ProMotion de 120Hz.',
            'price' => 6999.99,
            'address' => 'Calemba 2',
        ],
        [
            'name' => 'Notebook MacBook Pro M2',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/ae/cb/3a/14/48/v1_E10/E1029I7V.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=51402f13c43552110f99de8831428da585c806234ffa4870f568495c988445fb',
            'video' => 'https://example.com/videos/macbookpro.mp4',
            'description' => 'MacBook Pro 14" com chip Apple M2, 16GB RAM, 512GB SSD e tela Liquid Retina XDR.',
            'price' => 11999.99,
            'address' => 'Morro  Bento',
        ],
        [
            'name' => 'Console PlayStation 5',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/0b/c0/68/78/07/v1_E10/E102JEIU.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=4fc1294d61d740617824111227ff853a89d0cb179a0e88c6b0e9a51e798b66ea',
            'video' => 'https://example.com/videos/ps5.mp4',
            'description' => 'Console Sony PlayStation 5 com suporte a 4K, SSD ultrarrápido e controle DualSense.',
            'price' => 4999.99,
            'address' => 'Benfica',
        ],
        [
            'name' => 'Smart TV Samsung 55" 4K',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/1d/49/c5/02/3b/v1_E10/E101DCEG.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=34f9e926030b10fad399aace3047f2beed0c837f4536d010cc8ef5c205f59899',
            'video' => 'https://example.com/videos/smarttv.mp4',
            'description' => 'Smart TV Samsung Crystal UHD 55" com HDR10+, Alexa integrada e taxa de atualização de 120Hz.',
            'price' => 3799.99,
            'address' => 'Luanda sul',
        ],
        [
            'name' => 'Monitor Gamer ASUS 27"',
            'image' => 'hhttps://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/f5/34/b2/04/9b/v1_E10/E109DTJ7.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=fced0b0341bfae98d07afaf7066409a9a9d9c2e4e38dbe7b441874ab4dd219b9',
            'video' => 'https://example.com/videos/monitorasus.mp4',
            'description' => 'Monitor ASUS ROG Strix 27" 165Hz, 1ms de resposta, painel IPS e tecnologia G-Sync.',
            'price' => 2299.99,
            'address' => 'Futungo',
        ],
        [
            'name' => 'Teclado Mecânico Razer BlackWidow',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/40/b9/da/ad/95/v1_E10/E1076GL5.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=6553ee2dbe98dea30fef8519f920bba7575f7c3f4bd77a27481622b8c07de213',
            'video' => 'https://example.com/videos/keyboard.mp4',
            'description' => 'Teclado mecânico Razer BlackWidow com switches Green, RGB Chroma e construção em alumínio.',
            'price' => 899.99,
            'address' => 'Luanda sul',
        ],
        [
            'name' => 'Mouse Gamer Logitech G Pro',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/twenty20/production/uploads/items/90bf7fdb-3686-436e-b7c9-f7e3892f8fcf/source?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=7206a98c29555069a75db946543be03dbd8bfec5423f31a8315436fbb077a8f7',
            'video' => 'https://example.com/videos/mouse.mp4',
            'description' => 'Mouse Gamer Logitech G Pro sem fio com sensor HERO 25K e botões programáveis.',
            'price' => 599.99,
            'address' => 'Viana',
        ],
        [
            'name' => 'Fone Bluetooth JBL Tune 125TWS',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/caff/b791-2a78-4886-ae78-1a522d0455e0/2582202.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=f5286086ae846d30917aa0e4d707b2bab4f9c9ddc0945816b444e4a56f66b619',
            'video' => 'https://example.com/videos/jbltune.mp4',
            'description' => 'Fones de ouvido JBL Tune 125TWS com graves potentes, Bluetooth 5.0 e autonomia de 32h.',
            'price' => 499.99,
            'address' => 'Camama',
        ],
        [
            'name' => 'Câmera Canon EOS R6',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/44/72/3c/fc/7a/v1_E10/E1027ZC7.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=679e017ed9f818428bc7364c56e71cd005a6358c0be76f238d996b9fd2848886',
            'video' => 'https://example.com/videos/canonr6.mp4',
            'description' => 'Câmera Mirrorless Canon EOS R6 com sensor Full Frame de 20MP e gravação em 4K 60fps.',
            'price' => 13499.99,
            'address' => 'Patriota',
        ],
        [
            'name' => 'Roteador Wi-Fi 6 TP-Link AX1800',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/47/6a/34/0b/db/v1_E10/E104R2QG.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=a318ebe2dad3f50a39b78813f848e36033d6861b53db005973f5169ccaf457a5',
            'video' => 'https://example.com/videos/router.mp4',
            'description' => 'Roteador TP-Link Archer AX1800 Wi-Fi 6 com velocidades de até 1.8Gbps e tecnologia OFDMA.',
            'price' => 699.99,
            'address' => 'Camama',
        ],
        [
            'name' => 'Impressora Multifuncional Epson EcoTank L3250',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/bbde/2474-6e28-4eb2-b3fd-7ac17ab2985e/052816%20(4).jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=e6933a171ecb835b34974e3bd023d373f1bd8a4818a9c583eb84decd119f0e04',
            'video' => 'https://example.com/videos/impressora.mp4',
            'description' => 'Impressora Epson EcoTank L3250 com sistema de tanque de tinta e conexão Wi-Fi.',
            'price' => 1699.99,
            'address' => 'Camama',
        ],
        [
            'name' => 'Aspirador Robô Xiaomi Mi Robot Vacuum',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/53/5b/fd/fa/b8/v1_E10/E103GH3A.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=26839a8fb8ecefc89d62384cbfb2a5750bce2e881aadd8528628754b16159d4e',
            'video' => 'https://example.com/videos/robotvacuum.mp4',
            'description' => 'Aspirador Robô Xiaomi com mapeamento inteligente e controle via aplicativo.',
            'price' => 1999.99,
            'address' => 'Patriota',
        ],
        [
            'name' => 'Monitor UltraWide LG 34"',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/3d/72/96/28/d7/v1_E11/E11KU20.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=b0ff941adb2ec4cc2571474fd13d3fe06996c6edda7265b0dbef178a35ef8128',
            'video' => 'https://example.com/videos/monitorlg.mp4',
            'description' => 'Monitor LG UltraWide 34" IPS, 75Hz, resolução 2560x1080 e suporte HDR10.',
            'price' => 2499.99,
            'address' => 'Luanda sul',
        ],
        [
            'name' => 'Mousepad Gamer RGB SteelSeries',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/e3/5f/7f/6e/5a/v1_E10/E105HBCZ.jpeg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=d813d13db0e5a4df491f15570b385df65e178dcc17e5ecac46efa0bdb25a2bce',
            'video' => 'https://example.com/videos/mousepad.mp4',
            'description' => 'Mousepad gamer SteelSeries QcK Prism RGB, superfície otimizada e base antiderrapante.',
            'price' => 249.99,
            'address' => 'Mutamba',
        ],
        [
            'name' => 'Tênis Nike Air Force 1',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/dd/15/60/9c/57/v1_E10/E105R2T7.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=6a100f7e032560cd0f001c9aa3fd934196b82641b3545356264370cd9129fb01',
            'video' => 'https://example.com/videos/nike-airforce.mp4',
            'description' => 'Tênis clássico Nike Air Force 1, disponível em várias cores, confortável e estiloso.',
            'price' => 799.99,
            'address' => 'Samba',
        ],
        [
            'name' => 'Relógio Analógico Fossil',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/0949/aede-e379-4205-a54e-415ec89989d5/DSC_4273-blue.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=4b88df407ccdc1b824a07613ecab66c355dc7bccb455bd2e08173d9e83d8374f',
            'video' => 'https://example.com/videos/relogio-fossil.mp4',
            'description' => 'Relógio Fossil de aço inoxidável, resistente à água, ideal para uso casual e social.',
            'price' => 1299.99,
            'address' => 'Morro da Luz',
        ],
        [
            'name' => 'Jaqueta de Couro Masculina',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/98/81/ac/ed/fc/v1_E10/E105R1J7.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=88bb977c40c7529ff3910dbeae4e1cb31c2227b683f544b46dbca531e9b1235c',
            'video' => 'https://example.com/videos/jaqueta-couro.mp4',
            'description' => 'Jaqueta de couro legítimo, modelo clássico para homens, resistente e elegante.',
            'price' => 1099.99,
            'address' => 'Ingombota',
        ],
        [
            'name' => 'Mala de Viagem Samsonite',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/ef26/4e05-cd70-4414-939e-e95181c6006c/DSC_0564-Exposure.JPG?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=cbd9a71266508bb4a0558c6d4de3d2d6e6bd837a21371f6236607fc1848550a4',
            'video' => 'https://example.com/videos/mala-samsonite.mp4',
            'description' => 'Mala de viagem Samsonite com cadeado TSA, leve e resistente, ideal para viagens longas.',
            'price' => 899.99,
            'address' => 'Mainga',
        ],
        [
            'name' => 'Cadeira ergonômica reclinável',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/6b/29/84/1d/f7/v1_E10/E104YWCG.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=03683ab38c1bb6627de783356c7297e8025020757e665be682fa56e90b8b4ae4',
            'video' => 'https://example.com/videos/cadeira-gamer.mp4',
            'description' => 'Cadeira ergonômica reclinável com apoio para os pés, ideal para jogos e trabalho.',
            'price' => 1499.99,
            'address' => 'Samba',
        ],
        [
            'name' => 'Perfume Paco Rabanne One Million',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/c6/81/f1/3b/11/v1_E10/E1029KDZ.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=94073566f412bd17a46728b5b4bf6b667ab7001331f1f005ee256aadf3b309df',
            'video' => 'https://example.com/videos/perfume-paco-rabanne.mp4',
            'description' => 'Perfume masculino Paco Rabanne One Million, fragrância intensa e sofisticada.',
            'price' => 699.99,
            'address' => 'Benfica',
        ],
        [
            'name' => 'Kit de Maquiagem Profissional',
            'image' => 'https://elements-resized.envatousercontent.com/envato-shoebox/1239/536d-75f3-4d62-bc6a-4fc501360ff1/Cosmetic%20Fly%2012%203.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=e04911c8947af774d155a32a8399018ba877ff1e9f37d42d8a4183388cca3b4b',
            'video' => 'https://example.com/videos/maquiagem-kit.mp4',
            'description' => 'Kit completo de maquiagem profissional com base, sombras, batom e pincéis.',
            'price' => 349.99,
            'address' => 'Futungo',
        ],
        [
            'name' => 'Cama Box Queen Ortobom',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/b3/0b/c9/55/82/v1_E11/E11HEQY.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=4a52d2705929534124d4d741b3bdc9007be8e36d433409a8703bd29b03506b84',
            'video' => 'https://example.com/videos/cama-box.mp4',
            'description' => 'Cama Box Queen Ortobom com colchão de molas ensacadas, super confortável.',
            'price' => 2499.99,
            'address' => 'Camama 2',
        ],
        [
            'name' => 'Bicicleta Caloi Aro 29',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/bd/52/36/90/25/v1_E10/E101AHAK.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=52153c4d0cabe1a1bdc4dcf11ae899c84618d52d6efe24ee6f468366174a0e0a',
            'video' => 'https://example.com/videos/bicicleta-caloi.mp4',
            'description' => 'Bicicleta Caloi Aro 29, com suspensão dianteira, freios a disco e 21 marchas.',
            'price' => 1899.99,
            'address' => 'Morro Bento',
        ],
        [
            'name' => 'Churrasqueira Elétrica Mondial',
            'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/01/d4/5b/da/81/v1_E10/E1028FQG.jpg?w=800&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=365e0aae075794c35206a18bc8742f3881f8452d246e81c7928969c40057aff1',
            'video' => 'https://example.com/videos/churrasqueira.mp4',
            'description' => 'Churrasqueira elétrica Mondial com controle de temperatura, sem fumaça e fácil de limpar.',
            'price' => 349.99,
            'address' => 'Luanda sul',
        ]
    ];


    public const MATERIAL_COSNTRUCAO = [
        [
            'name' => 'Baldes de Tintas',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/2bfa8414-58df-4029-b891-8f8736036ab2?w=2038&cf_fit=scale-down&q=85&format=auto&s=765db7871d1bf31d859a32c3bcbaefc369ae606b1c273a9d3f39eb5db4bdc9bb',
            'video' => 'https://example.com/videos/iphone14pro.mp4',
            'description' => 'Balde de tinta de alta qualidade para pintura profissional e doméstica.',
            'price' => 6999.99,
            'address' => 'Calemba 2',
        ],
        [
            'name' => 'Cimento Bag Mockup',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/ec34f69c-b3bd-4ee1-91cb-afd0b08161e4?w=2038&cf_fit=scale-down&q=85&format=auto&s=b8489373764f50a37f7fdc25667bcbbedb1461f74f523e02c3d39bd0afe9f377',
            'video' => 'https://example.com/videos/macbookpro.mp4',
            'description' => 'Saco de cimento resistente, ideal para construção e reformas.',
            'price' => 11999.99,
            'address' => 'Morro Bento',
        ],
        [
            'name' => 'Escova de parede',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/48c670eb-8dcb-41cf-854c-106e28f9d99a?w=2038&cf_fit=scale-down&q=85&format=auto&s=424e9c697885e4953160da5f656047ad440708f56aa501650eaedfddcbcdb0b9',
            'video' => 'https://example.com/videos/ps5.mp4',
            'description' => 'Escova de parede para acabamento e limpeza de superfícies antes da pintura.',
            'price' => 4999.99,
            'address' => 'Benfica',
        ],
    ];

    public const PRODUTO_ALIMENTAR = [
        [
            'name' => 'Bolacha Oat',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/920a80af-b382-4f2c-9f42-19fe912178ce?w=2038&cf_fit=scale-down&q=85&format=auto&s=f0dd1ef53d0913e97e8055369fcc38676a7bed75e80a02c91761bcc769ed0f7f',
            'video' => 'https://example.com/videos/iphone14pro.mp4',
            'description' => 'Bolacha crocante de aveia, perfeita para um lanche saudável e nutritivo.',
            'price' => 699.99,
            'address' => 'Calemba 2',
        ],
        [
            'name' => 'Fruta Maçã',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/074df8f7-c24b-4693-b8c6-7a024aa795e8?w=2038&cf_fit=scale-down&q=85&format=auto&s=f2d734b7744a69eb5c44cb9699185f0a4715fad0cf4dba95d99826c87896aaf2',
            'video' => 'https://example.com/videos/macbookpro.mp4',
            'description' => 'Maçã fresca e suculenta, rica em fibras e vitaminas para uma alimentação saudável.',
            'price' => 119.99,
            'address' => 'Morro Bento',
        ],
        [
            'name' => 'Arroz Craf Box',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/a4280264-3d18-452f-a173-211aee254ffa?w=2038&cf_fit=scale-down&q=85&format=auto&s=01c1bca72845f0f5d671893a460e5afd4673ac60c7a9de22869986f59d6454a9',
            'video' => 'https://example.com/videos/ps5.mp4',
            'description' => 'Arroz de qualidade premium, perfeito para preparar refeições saborosas e nutritivas.',
            'price' => 4999.99,
            'address' => 'Benfica',
        ],
    ];

    public const PRODUTO_BELEZA = [
        [
            'name' => 'Creme Articles Design',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/2af9bf12-574f-4eb6-b25d-bdec8fc70bc3?w=2038&cf_fit=scale-down&q=85&format=auto&s=4a0bf96d3840443a8f2e0818334f262eb91d07686ea962f8365a06418c9e85da',
            'video' => 'https://example.com/videos/iphone14pro.mp4',
            'description' => 'Creme hidratante para rosto e corpo, com fórmula nutritiva para uma pele macia e radiante.',
            'price' => 699.99,
            'address' => 'Calemba 2',
        ],
        [
            'name' => 'Creme Mockup',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/e24edfab-aa88-421c-8474-0cc5f429fe7f?w=2038&cf_fit=scale-down&q=85&format=auto&s=a1a2331edd2296e90060a860977acf293fbdf73c5ea7019b87427e85aebf7c04',
            'video' => 'https://example.com/videos/macbookpro.mp4',
            'description' => 'Loção hidratante com fragrância suave, ideal para cuidados diários e proteção da pele.',
            'price' => 119.99,
            'address' => 'Morro Bento',
        ],
        [
            'name' => 'Creme Bitel',
            'image' => 'https://elements-resized.envatousercontent.com/elements-cover-images/b59a246c-62bd-421a-9951-e8976e442588?w=2038&cf_fit=scale-down&q=85&format=auto&s=5227e2a4323fad43c95079c9d3e4fdbf2ee253820f109fa8a186493949143b16',
            'video' => 'https://example.com/videos/ps5.mp4',
            'description' => 'Creme anti-idade com ativos naturais, reduzindo rugas e proporcionando uma pele jovem e saudável.',
            'price' => 4999.99,
            'address' => 'Benfica',
        ],
    ];

    public function run()
    {
        $users = User::inRandomOrder()->take(6)->get();
        $categories = Category::where('type', 'product')->get();
        $this->seederProduct($users, $categories, self::PRODUCTS);

        $phones = $this->getUsers(UserSeeder::SUPPLIER_MATERIAL);
        $users = User::whereIn('phone', $phones)->get();
        $categories = Category::where('code', 'MATERIAL_CONSTRUCAO')->get();
        $this->seederProduct($users, $categories, self::MATERIAL_COSNTRUCAO);

        $phones = $this->getUsers(UserSeeder::SUPPLIER_ALIMENTO);
        $users = User::whereIn('phone', $phones)->get();
        $categories = Category::where('code', 'PRODUTO_ALIMENTAR')->get();
        $this->seederProduct($users, $categories, self::PRODUTO_ALIMENTAR);

        $phones = $this->getUsers(UserSeeder::SUPPLIER_BELEZA);
        $users = User::whereIn('phone', $phones)->get();
        $categories = Category::where('code', 'PRODUTO_BELEZA')->get();
        $this->seederProduct($users, $categories, self::PRODUTO_BELEZA);
    }

    private function getUsers($users){
        return collect($users)->map(function($it){ return $it['phone']; })->all();
    }

    private function seederProduct($users, $categories, $products){

        if ($users->isEmpty() || $categories->isEmpty()) return;

        foreach ($products as $item) {
            $item['user_id'] = $users->random()->id;
            $item['category_id'] = $categories->random()->id;
            $item['concat'] = "{$item['name']}#{$item['price']}#{$item['description']}";

            $data = array_merge($item, ['uuid' => Str::uuid()->toString()]);
            Product::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}
