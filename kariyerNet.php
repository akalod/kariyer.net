<?php
class kariyerNet
{

    public $link = 'https://www.kariyer.net/firma-profil/eruslu-saglik-urunleri-san-ve-tic-a-s-43761-211950';

    public $jobs;

    function __construct($link = Null)
    {
        if ($link) {
            $this->link = $link;
        }
        $this->parser();
    }

    private function parser()
    {
        $data = file_get_contents($this->link);

        $dom = new DomDocument();
        @$dom->loadHTML($data);
        $finder = new DomXPath($dom);
        $className = "job";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");

        foreach ($nodes as $k) {
            $path = $k->childNodes[1]->childNodes[1];
            $link = 'https://www.kariyer.net' . $path->getAttribute('href');
            $job = $path->childNodes[1]->nodeValue;
            $company = $path->childNodes[3]->nodeValue;
            $city = $path->childNodes[5]->nodeValue;
            $date = trim($k->childNodes[1]->childNodes[6]->childNodes[1]->nodeValue);
            $logo = $k->childNodes[1]->childNodes[3]->childNodes[0]->getAttribute('src');

            $this->jobs[] = Array(
                'job' => $job,
                'company' => $company,
                'city' => $city,
                'link' => $link,
                'logo' => $logo,
                'date' => $date
            );
        }
    }

}
