<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Stock;
use App\Models\Adress;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \DB::beginTransaction();
        Adress::factory(30)->create();

        User::factory()->create([
            'name' => "Erwan SORIA",
            'birthday' => "1998-01-26",
            'email' => "erwan.soria@gmail.com",
            'adresse_livraison_id' => 1,
            'adresse_facturation_id' => 1,
            'phone' => "+33 652501448",
            'password' => Hash::make('Bossdu76*'),
        ]);
        

        Article::factory()->create([
            'nom' => 'chaise',
            'prix' => '10000',
            'description' => "Offrez à votre intérieur une touche de sophistication avec notre chaise noire en aluminium. Conçue avec un souci du détail et de l'esthétique, cette chaise incarne l'élégance moderne. Son design épuré et ses lignes équilibrées ajoutent une note de raffinement à n'importe quelle pièce, qu'il s'agisse de votre salle à manger, de votre bureau ou de votre espace de réception. Fabriquée en aluminium de haute qualité, cette chaise garantit une robustesse à toute épreuve tout en restant légère et facile à déplacer. Ses quatre pieds stables offrent un soutien optimal, vous permettant de vous détendre en toute confiance. Que ce soit pour des repas en famille, des réunions entre amis ou des moments de travail concentré, cette chaise sera votre alliée de choix. Ajoutez une touche d'élégance à votre quotidien avec notre chaise en aluminium, un mélange parfait de style et de fonctionnalité.",
            'short_description' => "Chaise noire élégante en aluminium, parfaite pour compléter votre espace avec style. Avec ses quatre pieds robustes, cette chaise offre confort et durabilité.",
            'img_path' => '/storage/img/articles/chaise.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'commode',
            'prix' => '50000',
            'description' => "Optimisez l'organisation de votre espace de vie avec notre commode beige en bois d'acajou. Dotée de six tiroirs spacieux, cette commode offre un espace de rangement généreux pour vos sous-vêtements, chaussettes et autres petits articles essentiels. Son design classique et intemporel s'intègre harmonieusement dans n'importe quelle chambre à coucher, ajoutant une touche de chaleur et d'élégance à votre décor. Fabriquée à partir de bois d'acajou de haute qualité, cette commode allie beauté et durabilité, assurant une utilisation durable. Les poignées en métal ajoutent une touche de sophistication, facilitant l'ouverture et la fermeture des tiroirs. Que ce soit pour organiser votre garde-robe ou pour ajouter une touche de style à votre chambre, notre commode beige est le choix idéal. Offrez-vous un espace de rangement fonctionnel et esthétique avec notre commode en bois d'acajou, un meuble polyvalent conçu pour répondre à vos besoins de rangement quotidien.",
            'short_description' => "Commode beige pratique avec six tiroirs en bois d'acajou, idéale pour ranger vos sous-vêtements et chaussettes tout en apportant une touche de charme à votre chambre.",
            'img_path' => '/storage/img/articles/commode.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'étagère',
            'prix' => '6000',
            'description' => "Apportez une touche de charme rustique à votre espace avec notre étagère rectangulaire en bois de petite taille. Conçue pour les petits espaces, cette étagère compacte est idéale pour afficher vos objets préférés tels que des photos, des plantes en pot ou des bibelots. Fabriquée à partir de bois de haute qualité, cette étagère est à la fois solide et durable. Sa forme rectangulaire simple s'intègre facilement dans n'importe quel coin de votre maison, que ce soit dans votre salon, votre chambre à coucher ou même votre bureau. Grâce à sa taille compacte, elle peut également être utilisée comme solution de rangement pratique pour vos livres de poche ou vos petits accessoires. Avec son design épuré et sa finition naturelle, cette étagère ajoute une touche de chaleur et d'authenticité à tout espace. Transformez votre intérieur avec notre étagère en bois de petite taille, un meuble polyvalent qui allie fonctionnalité et style avec élégance.",
            'short_description' => "Étagère rectangulaire en bois de petite taille, parfaite pour afficher vos objets préférés tout en ajoutant une touche de rusticité à votre décor.",
            'img_path' => '/storage/img/articles/etagere.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'lit',
            'prix' => '100000',
            'description' => "Transformez votre chambre à coucher en un havre de modernité et d'élégance avec notre lit ultra design. Doté de pieds en arceau noir au design unique, ce lit incarne l'esthétique contemporaine et l'élégance minimaliste. Conçu pour ceux qui recherchent à la fois le confort et le style, ce lit offre un cadre épuré et sophistiqué pour des nuits de sommeil paisibles et réparatrices. Fabriqué avec des matériaux de haute qualité, ce lit allie durabilité et confort, offrant un soutien optimal pour un repos bien mérité. Son design épuré et ses lignes équilibrées ajoutent une touche de sophistication à votre chambre à coucher, créant un espace de vie qui respire la modernité et le raffinement. Que vous recherchiez un meuble de base pour une esthétique minimaliste ou un point focal pour une déclaration de style audacieuse, notre lit ultra design est le choix parfait pour une chambre à coucher chic et contemporaine.",
            'short_description' => "Lit ultra design avec pieds en arceau noir, incarnant l'élégance contemporaine et l'esthétique épurée pour une chambre à coucher sophistiquée.",
            'img_path' => '/storage/img/articles/lit.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'meuble rangement',
            'prix' => '30000',
            'description' => "Optimisez l'organisation de votre salle de bain tout en ajoutant une touche de charme rustique avec notre meuble sur pied en bois marron. Doté de quatre tiroirs spacieux, ce meuble offre un espace de rangement généreux pour vos produits de toilette, serviettes et autres essentiels de salle de bain. Fabriqué à partir de bois de haute qualité, ce meuble allie durabilité et esthétique, apportant une touche chaleureuse et naturelle à votre espace. Son design sur pied permet une utilisation efficace de l'espace au sol, idéal pour les salles de bain de toutes tailles. Les poignées discrètes sur les tiroirs ajoutent une touche de sophistication tout en facilitant l'ouverture et la fermeture en douceur. Que ce soit pour une salle de bain moderne ou traditionnelle, ce meuble sur pied en bois marron est un choix polyvalent qui complétera parfaitement votre décor tout en offrant un rangement pratique. Transformez votre salle de bain en un sanctuaire de détente et de style avec notre meuble sur pied en bois, un meuble fonctionnel et esthétique qui répond à tous vos besoins de rangement.",
            'short_description' => "Meuble de salle de bain sur pied en bois marron avec quatre tiroirs, offrant un rangement pratique et une touche de chaleur rustique à votre salle de bain.",
            'img_path' => '/storage/img/articles/meuble_sdb.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'miroir',
            'prix' => '10000',
            'description' => "Embellissez votre espace avec notre miroir ovale orné de détails dorés, une pièce maîtresse qui apporte une touche d'élégance à tout décor. Son design ovale unique et ses ornements dorés lui confèrent un charme intemporel qui captivera instantanément l'attention dans n'importe quelle pièce. Que ce soit dans votre entrée, votre chambre à coucher ou votre salon, ce miroir est plus qu'un simple reflet ; il est une œuvre d'art en soi. Fabriqué avec soin à partir de matériaux de haute qualité, ce miroir est conçu pour durer et ajouter une touche de sophistication à votre espace pendant de nombreuses années à venir. Accrochez-le au mur pour créer un point focal saisissant ou utilisez-le pour réfléchir la lumière et agrandir visuellement votre espace. Quelle que soit votre utilisation, notre miroir ovale avec des ornements dorés est un choix élégant qui rehaussera instantanément l'esthétique de votre maison, ajoutant une touche de luxe et de raffinement à votre décor.",
            'short_description' => "Miroir ovale orné de détails dorés, une pièce accrocheuse pour ajouter une touche d'élégance à n'importe quelle pièce.",
            'img_path' => '/storage/img/articles/miroir.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'table',
            'prix' => '5000',
            'description' => "Apportez une touche de modernité et de simplicité à votre espace avec notre petite table ronde blanche. Dotée d'un design épuré et minimaliste, cette table est parfaite pour ajouter fonctionnalité et style à n'importe quelle pièce. Son plateau rond en blanc pur offre une surface lisse et facile à nettoyer, idéale pour accueillir des boissons, des collations ou des objets décoratifs. Le pied central en aluminium ajoute une touche de modernité tout en offrant une stabilité solide à la table. Que ce soit comme table d'appoint dans le salon, table de chevet dans la chambre à coucher ou petite table à manger dans la cuisine, cette table polyvalente s'adapte à une variété de contextes et d'utilisations. Fabriquée avec des matériaux de haute qualité, cette table est conçue pour durer et résister à l'épreuve du temps, tout en ajoutant une touche de fraîcheur et de sophistication à votre décor. Optez pour la simplicité et l'élégance avec notre petite table ronde blanche, un ajout parfaitement polyvalent à tout espace moderne.",
            'short_description' => "Table ronde blanche simple avec pied central en aluminium, ajoutant une touche de modernité et de fonctionnalité à tout espace.",
            'img_path' => '/storage/img/articles/table.jpg', 
        ]);

        Article::factory()->create([
            'nom' => 'table de chevet',
            'prix' => '15000',
            'description' => "Complétez l'esthétique moderne de votre chambre à coucher avec notre table de chevet blanche contemporaine. Reposant sur quatre pieds en bois qui lui confèrent une stabilité et une élégance naturelle, cette table de chevet offre un équilibre parfait entre style et fonctionnalité. Avec ses deux tiroirs spacieux, elle offre un espace de rangement pratique pour vos livres, magazines, lunettes ou autres petits objets essentiels à garder à portée de main pendant la nuit. Son design épuré et minimaliste s'harmonise facilement avec une variété de décors, ajoutant une touche de fraîcheur et de sophistication à votre espace. Le blanc lumineux du meuble apporte une sensation de légèreté et d'ouverture, idéale pour créer une atmosphère apaisante dans votre chambre à coucher. Fabriquée avec des matériaux de haute qualité, cette table de chevet est conçue pour durer et résister à l'épreuve du temps, tout en ajoutant une touche de modernité à votre espace de repos. Optez pour le mariage parfait entre style et fonction avec notre table de chevet blanche contemporaine, un meuble indispensable pour une chambre à coucher bien aménagée.",
            'short_description' => "Table de chevet blanche contemporaine sur quatre pieds en bois avec deux tiroirs, alliant style et fonctionnalité pour compléter votre chambre à coucher.",
            'img_path' => '/storage/img/articles/table_chevet.jpg', 
        ]);
    

        Stock::factory(8)->create();

        

        try {
            // Vos opérations de création de données
            
            \DB::commit();
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            \DB::rollBack();
            throw $e;
        }
        
    }
}
