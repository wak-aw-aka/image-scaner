<?php

namespace app\models;

use Yii;
use linslin\yii2\curl;
use yii\db\ActiveRecord;

class UrlImg extends \yii\db\ActiveRecord 
{
    public static function tableName()
    {
        return 'urlImg';
    }

    public function rules()
    {
        return [[
                ['url'], 'required'],
                ['url', 'string', 'length' => [5, 250]],
                ['url', 'validateUrl'],
                [['url', 'date', 'data'], 'safe'],
        ];
    }

    // Валидация введеного Url
    public function validateUrl($attribute, $params)
    {
        if (!filter_var($this->$attribute, FILTER_VALIDATE_URL)) {
             $this->addError($attribute, 'Вы ввели некорректный Url');
        }
    }

    public function attributeLabels()
    {
        return [
          'id' => 'ID',
          'url' => 'Запрошеный Url',
          'date' => 'Дата добавления',
          'data' => 'data',
        ];
    }

    public function beforeSave($insert)
    {
        $this->date = date('Y-m-d H:i:s');
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getData() {
        return $this->data;
    }

    // взять картинки по Url
    public function scanByUrl()
    {
        try{

            mb_internal_encoding("UTF-8");

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $this->url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/cookieFileName"); 
            $response = curl_exec($ch); 
            curl_close($ch);
            
            $doc = new \DOMDocument();
            @$doc->loadHTML($response);
            @$xml    = simplexml_import_dom($doc);

            if (empty($xml)){
                $this->addError('url', 'По заданому Url изображений не найдено');
                return false;
            }

            @$images = $xml->xpath('//img');

            if (empty($images)){
                $this->addError('url', 'По заданому Url изображений не найдено');
                return false;
            }

            foreach ($images as $img) {
                if (filter_var($img['src'], FILTER_VALIDATE_URL)){
                  $data[] = (string)$img['src'];
                }else{

                    if (mb_substr($this->url, -1) == '/'){
                        $url = mb_substr($this->url, 0, mb_strlen($this->url) - 1, "UTF-8");
                    }else{
                        $url = $this->url; 
                    }

                    if ($img['src'] == ''){
                        continue;
                    }

                    if (mb_substr($img['src'], 0, 2, "UTF-8") == '//'){
                        $data[] = (string)$img['src'];
                    }else{
                        if (mb_substr($img['src'], 0, 1, "UTF-8") == '/'){
                            $parsUrl = parse_url($url);
                            $data[]  = $parsUrl['scheme'] . '://' . $parsUrl['host'] . $img['src'];
                        }else{
                            $data[] = $url . '/' . mb_substr( $img['src'], 0);
                        }
                    }
                }
            }

            $this->data = json_encode($data);

            return true;
        }catch(exception $e){
            $this->addError($attribute, 'При запросе возникли проблемы: ',  $e->getMessage());
            return false;
        }

    }

}