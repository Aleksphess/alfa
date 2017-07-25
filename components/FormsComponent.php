<?php

namespace app\components;
 
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Forms;
use app\models\FormTypes;
use app\models\Files;

class FormsComponent extends Component
{
    public $formType;

    public function addForm() 
    {
        $post = Yii::$app->request->post();
        
        /*if (isset($post['g-recaptcha-response'])) {
			if(!empty($post['g-recaptcha-response']) && $curl = curl_init() ) {
				curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_POST, true);
				$postFields = "secret=6LeedB0UAAAAAPaIJ5cRl1QEmB3IaELW7OOar_zh";
				$postFields.= "&response=".$post['g-recaptcha-response'];
				curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
				$out = curl_exec($curl);
				curl_close($curl);
				$gData = json_decode($out);
				if ($gData->success !== TRUE) {
					return false;
				}
			} else {
				return false;
			}
		}*/
		if (isset($post['is_recaptcha'])) {
			if(empty($post['recaptcha']) || !empty($post['recaptcha_in'])) {
				return false;
			}
		}
        
        $newForm = new Forms();
        $newForm->alias = 'form_'.(string)time();
        $newForm->pub_date = date('Y-m-d');
        $newForm->pub_time = date('H:i');
        $newForm->status = 0;
        $newForm->name = (isset($post['name'])) ? addslashes(strip_tags($post['name'])) : '';
        if (strpos($newForm->name,"58f") !== false) {
			return false;
		} 
        $newForm->email = (isset($post['email'])) ? addslashes(strip_tags($post['email'])) : '';
        $newForm->phone = (isset($post['phone'])) ? addslashes(strip_tags($post['phone'])) : '';
        $newForm->msg = (isset($post['msg'])) ? addslashes(strip_tags($post['msg'])) : '';
        $newForm->msg .= "<br/>".$_SERVER['REMOTE_ADDR'];
        $newForm->form_id = $this->getFormTypeId();
        $newForm->sort = 1;
        $newForm->creation_time=(string)date('U');
        $newForm->update_time=(string)date('U');
        $result = $newForm->save();
        

        if ($result) {
            $file1 = \yii\web\UploadedFile::getInstanceByName('file1');
            $this->attachFile($file1, $newForm);
            $file2 = \yii\web\UploadedFile::getInstanceByName('file2');
            $this->attachFile($file2, $newForm);
            $newForm->fillErrMsg();
        }
        if ($result) { 
            if (empty($this->formType)) {
                $email = \app\models\UserSettings::findOne(['alias' => 'user_email']);
                if($email){
                    mail($this->formType->email, "Новая заявка с сайта", $newForm->msg);
                    // Yii::$app->mailer->compose('forms/new', ['data' => $newForm])
                    //             ->setFrom('site@alfa-spa.com')
                    //             ->setTo($email->value)
                    //             ->setSubject('Новая заявка с сайта')
                    //             ->send();
                }
            } else {
                $emails = explode(",", $this->formType->email);
                $emailsTrim = [];
                foreach ($emails as $email){
                     $emailsTrim[] = trim($email);
                }
                
                $subject = "Новая заявка: " . $this->formType->name;
                
                $encoded_subject = "=?utf-8?b?".base64_encode(stripslashes($subject))."?=";
                
                $headers = "From: <noreply@alfa-spa.com>\n";
				$headers .= "Return-Path: <noreply@alfa-spa.com>\n";  // Return path for errors
				$headers .= "Content-Type: text/html; charset=utf-8\n"; // Mime type
				$headers .= "bcc: ";
                

//iconv( 'UTF-8', 'Windows-1251',
                mail($this->formType->email,  $encoded_subject,  $newForm->name.' '.$newForm->phone.' '.$newForm->email.' '.$newForm->msg, $headers);
                // Yii::$app->mailer->compose('forms/new', ['data' => $newForm])
                //                  ->setFrom('site@alfa-spa.com')         
                //                  ->setTo($emailsTrim)
                //                  ->setSubject('Новая заявка с сайта')
                //                  ->send();

            }
            return true;
        } else {
            return false;
        }
    }
    
    private function attachFile($file, $form)
    {
        $fileRow = new Files();
        if ($fileRow->attachFile($file, 'forms', $form->id) === false) {
            $form->attachFileErrors[] = $file->name;
            return false;
        }
        return true;
    }
    
    private function getFormTypeId()
    {
        $form_type = Yii::$app->request->post('form_type',false);
        if (!$form_type) {
            return (-1);
        }
        $this->formType = FormTypes::findOne(['alias' => addslashes($form_type)]);
        if (!$this->formType) {
            return (-1);
        }
        return $this->formType->id;
    }
}
