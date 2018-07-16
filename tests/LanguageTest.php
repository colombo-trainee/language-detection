<?php

declare(strict_types = 1);

namespace LanguageDetection\Tests;

use LanguageDetection\Language;
use LanguageDetection\Tokenizer\TokenizerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class LanguageTest
 *
 * @copyright 2016-2018 Patrick Schur
 * @license https://opensource.org/licenses/mit-license.html MIT
 * @author Patrick Schur <patrick_schur@outlook.de>
 * @package LanguageDetection\Tests
 */
class LanguageTest extends TestCase
{
    public function testAll()
    {
        $l = new Language();

        foreach (new \GlobIterator(__DIR__ . '/../resources/*/*.txt') as $txt)
        {
            $content = file_get_contents($txt->getPathname());

            $this->assertEquals(key($l->detect($content)->close()), $txt->getBasename('.txt'));
        }
    }

    public function testConstructor()
    {
        $l = new Language(['de', 'en', 'nl']);

        $array = $l->detect('Das ist ein Test')->close();

        $this->assertEquals(3, count($array));

        $this->assertArrayHasKey('de', $array);
        $this->assertArrayHasKey('en', $array);
        $this->assertArrayHasKey('nl', $array);
    }

    public function testTokenizer()
    {
        $stub = $this->createMock(Language::class);

        $stub->method('setTokenizer')->willReturn('');

        /** @var Language $stub */
        /** @noinspection PhpVoidFunctionResultUsedInspection */
        $this->assertEquals('', $stub->setTokenizer(new class implements TokenizerInterface
        {
            public function tokenize(string $str): array
            {
                return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
            }
        }));
    }

    /**
     * @param $expected
     * @param $sample
     * @dataProvider sampleProvider
     */
    public function testSamples(string $expected, string $sample)
    {
        $l = new Language();

        $this->assertEquals($expected, key($l->detect($sample)->close()));
    }

    /**
     * @return array
     */
    public function sampleProvider()
    {
        return [
            ['de', 'Ich wünsche dir noch einen schönen Tag'],
            ['ja', '最近どうですか。'],
            ['en', 'This sentences should be too small to be recognized.'],
            ['nl', 'Mag het een onsje meer zijn? '],
            ['hi', 'मुझे हिंदी नहीं आती'],
            ['et', 'Tere tulemast tagasi! Nägemist!'],
            ['pl', 'Wszystkiego najlepszego z okazji urodzin!'],
            ['pl', 'Czy mówi pan po polsku?'],
            ['fr', 'Où sont les toilettes?'],
            ['ja', '丹後ちりめんは、京都府北部の丹後地方特有の撚糸技術を用いた後染め絹織物であり、広義では丹後地方の絹織物全般の代名詞である。1メートルあたり3,000回程度の強い撚りをかけた緯糸を使っており、製織後、生糸の表面を覆うセリシンを精練で取り除くことで、生地の表面にシボと呼ばれる凹凸を生み出し、一般の絹織物には出せないしなやかな肌触りや、染めつけの良さ、豊かな深い色合いを作りだしている。……'],
            ['ja', '富士電視臺的下午新聞節目將會有大大改變 富士電視臺的下午新聞節目將會有大大改變 富士電視臺的下午新聞節目將會有大大改變 富士電視臺的下午新聞節目將會有大大改變 ばねとは、力が加わると変形し、力を取り除くと元に戻るという、物体の弾性という性質を利用する機械要素である。形状や材質は様々で、日用品から車両、電気電子機器、構造物に至るまで、非常に多岐にわたって使用される。ばねの種類の中ではコイルばねがよく知られ、板ばね、渦巻ばね、トーションバー、皿ばねなどがある。ばねの材料には金属が広く用いられているが、用途に応じてゴム、プラスチック、セラミックスといった非金属材料も用いられ、空気を用いた空気ばねなどもある。荷重を変形量で示させたり、振動や衝撃を緩和したり、弾性エネルギーの貯蔵と放出を行わせたりなど、色々な用途のためにばねが用いられる…… 20150223 1936 WMAT Spring 0965 (rotated and cropped).jpg
'],
            ['ja', '広州天河飛行場は、広東省広州市東郊の番禺県天河村（現天河区）付近にかつて存在した飛行場。北面にそびえる丘陵「瘦狗嶺」から、瘦狗嶺機場とも呼ばれた。1928年12月に建設が開始され、1931年7月より私設の広東空軍によって使用。……
'],
            ['es', 'Todos los llamados productos “milagro” tienen efectos secundarios y algunos pueden poner en riesgo la vida de quien los consume, reveló el titular de la Unidad de Control Sanitario en la localidad, Jesús Fernando Gutiérrez Fraijo.
Todos tienen alguna consecuencia en la salud y los productos mágicos pueden ser aquellos que prometen lograr que las personas bajen rápidamente peso o aquellos que dicen curar todo tipo de enfermedades.
“Todos repercuten de alguna forma en complicaciones en la salud, por ejemplo, si se pierden kilos en poco tiempo, el cuerpo se va a descompensar”, mencionó.'],
            ['es', 'Gutiérrez indicó que los productos “mágicos” que más circulan entre la población son los que prometen hacer que la persona pierda peso rápido y quien los consume pueden afectar el sistema endocrinológico que es el que regula las grasas.
Dijo que son pocas las denuncias que se reciben ya que las personas compran estos productos en línea o por redes sociales y generalmente se los llevan a domicilio, por lo que no hay un lugar fijo dónde reclamar.'],
            ['es', 'Lo bueno es la legalización de la marihuana medicinal para todos los pacientes que lo soliciten, para aliviar algunas enfermedades'],
            ['id', 'Faktual, pembelajaran berpusat pada guru. Guru berbicara dan siswa mendengar dan menyimak, dan menulis. Guru mengajar. '],
            ['id', 'Komunikasi adalah suatu proses penyampaian informasi atau pesan dalam ruang lingkup individu, antar individu, maupun kelompok. Pada dasarnya komunikasi adalah sarana yang digunakan manusia untuk melakukan interaksi sosial, yang merupakan kebutuhan manusia itu sendiri sebagai makhluk sosial. Manusia memiliki kemampuan untuk menyampaikan keinginan dan hasrat diri kepada orang lain. Hal tersebut merupakan awal dari keterampilan berkomunikasi yang dimiliki oleh manusia secara otomatis dan alamiah melalui lambang-lambang, isyarat (non-verbal),  kemudian disusun dengan kemampuan untuk memberi arti dari lambang tersebut kedalam bentuk verbal. Komunikasi yang terjadi sebagai bentuk interaksi sosial inilah kemudian akan mempengaruhi individu. Informasi yang diterima dari lingkungan mengenai dirinya dan gambaran dari individu lainnya yang menurutnya ideal akan mempengaruhi perilaku manusia'],
            ['id', 'Secara umum konsep diri dibagi atas beberapa bagian, gambaran diri (body/self image), ideal diri dan harga diri (self esteem). Sikap seseorang terhadap dirinya secara sadar ataupun tidak sadar merupakan gambaran atas diri orang tersebut. Sikap ini mencakup persepsi dan perasaan tentang ukuran, bentuk, fungsi penampilan dan potensi tubuh saat ini dan masa lalu yang secara berkesinambungan dimodifikasi dengan pengalaman baru setiap individu. Sejak lahir individu mengeksplorasi bagian tubuhnya, menerima informasi yang diberikan orang lain, kemudian mulai memanipulasi lingkungan dan mulai sadar dirinya merupakan bagian yang terpisah dari lingkungan. Gambaran diri sangat erat kaitannya dengan kepribadian. Cara individu memandang dirinya akan sangat berpengaruh terhadap psikologisnya. Setiap individu tentu ingin merasa aman. Ternyata, langkah utama untuk merasa aman secara utuh ialah memandang diri secara utuh yaitu menerima dan mengukur bagian tubuhnya.'],
            ['pt-PT', 'O outro jogador da lista é ninguém menos do que o Rei do Futebol. Pelé fez dois gols nos 5 a 2 sobre a Suécia, na decisão de 1958. Na época o craque tinha apenas tinha 17 anos. "O segundo adolescente a marcar um gol em uma final de #CopaDoMundo! Bem-vindo ao clube, Kylian - é ótimo ter a sua companhia!", escreveu o brasileiro em sua conta no Twitter para parabenizar Mbappé.'],
            ['pt-PT', 'Além do gol, Mbappé também se tornou o terceiro jogador sub-20 a ser campeão de uma Copa do Mundo. Além dele e Pelé, o italiano Giuseppe Bergomi está na lista ao levantar a taça em 1982, quanto tinha 18 anos.
Em campo, a França derrotou a Croácia no Estádio Olímpico Lujniki, em Moscou, e conquistou a Copa do Mundo pela segunda vez na história. Mandzukic (contra), Griezmann, Pogba e Mbappé fizeram os gols franceses, enquanto Perisic e Madzukic descontaram para a Croácia.
'],
            ['pt-PT', 'Uma maneira comum de avaliar o quanto um jogador é melhor do que outro, o quanto um time valoriza um atleta em detrimento de outro é o salário que cada um recebe (surpresa: não é só no basquete que isso acontece…). Por mais que para um torcedor o que importe seja a bola na cesta, a folha salarial determina o quanto cada time pode fazer, contratar, renovar e o contracheque do atleta, mesmo em uma liga de milionários onde dinheiro não é mais problema para ninguém, é a melhor medida de status.
'],
        ];
    }
}