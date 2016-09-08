<?php

/**
 * this file contains the UGMail class and all the UGMailMessage classes
 * @author Nicola Puddu
 * @package userGroups
 * @since 1.6
 */

/**
 * This class takes care of collecting the mail message info
 * and send it to the desired user
 * @author Nicola Puddu
 */
class UGMail {

    /**
     * these constants define the three kind of mail messages
     * @var string
     */
    const ACTIVATION = 'activation';
    const PASS_RESET = 'pass_reset';
    const INVITATION = 'invitation';

    /**
     * @var string the admin mail in the application settings
     */
    protected $_from;

    /**
     * @var string the user email
     */
    protected $_to;

    /**
     * @var array the data used by Yii::t() to complete the messages
     */
    protected $_data;

    /**
     * @var string the email headers
     */
    protected $_header;

    /**
     * @var string the email subject
     */
    protected $_subject;

    /**
     * @var string the email message
     */
    protected $_body;

    /**
     * @var string the flash message displayed in case of no errors
     */
    protected $_sent;

    /**
     * @var string the flash message displayed in case of errors
     */
    protected $_error;

    /**
     * load the email data inside the object
     * @param UserGroupsUser $model the user will receive the email
     * @param string $message rappresent what kind of mail message the user will receive. refers to the three constants
     */
    public function __construct(UserGroupsUser $model, $message) {
        $this->_from = Yii::app()->params->adminEmail;
        // extract user data
        $this->extractUserData($model);
        // extract the mail classes defined
        $mailMessages = Yii::app()->controller->module->mailMessages;
        $mailMessage = isset($mailMessages[$message]) ? new $mailMessages[$message] : $this->defaultMailMessage($message);
        // populate the mail attributes
        $this->_header = $mailMessage->mailHeader($this->_from);
        $this->_subject = $mailMessage->mailSubject($this->_data);
        $this->_body = $mailMessage->mailBody($this->_data) . $mailMessage->mailSignature($this->_data);
        // pupulate the flash messages
        $this->_sent = $mailMessage->mailSuccess($this->_data);
        $this->_error = $mailMessage->mailError($this->_data);
    }

    /**
     * send the email message and set the flash messages
     */
    public function send() {
        /* if (mail($this->_to, $this->_subject, $this->_body, $this->_header))
          Yii::app()->user->setFlash('mail', $this->_sent);
          else
          Yii::app()->user->setFlash('mail', $this->_error); */


        /* $message = 'Correo exitoso';
          $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
          $mailer->Host = 'exchfe01.cantv.com.ve';
          //$mailer->Host = 'smtp.cantv.com.ve';
          $mailer->IsSMTP();
          $mailer->From = 'sir-php@cantv.com.ve';
          //$mailer->AddReplyTo('wei@example.com');
          $mailer->AddAddress('jgomez15@cantv.com.ve');
          $mailer->AddAddress('gramir04@cantv.com.ve');
          $mailer->FromName = 'Juan Gomez';
          $mailer->CharSet = 'UTF-8';
          //$mailer->Subject = Yii::t('demo', 'Yii rulez!');
          $mailer->Subject = 'correo sir-php';
          $mailer->Body = $message; */




        //var_dump($this->_to);
        //die();
        //$message = 'Correo exitoso';
        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        $mailer->Host = 'mail.me.gob.ve:25';
        //$mailer->Host = 'smtp.cantv.com.ve';
        $mailer->IsSMTP();
        $mailer->From = $this->_from; /*         * ************************** */
        //$mailer->AddReplyTo('wei@example.com');
        //$mailer->AddAddress($this->_to);
        $mailer->AddAddress($this->_to);
        //$mailer->AddAddress('gramir04@cantv.com.ve');
        $mailer->FromName = Yii::app()->params->adminName;
        $mailer->CharSet = 'UTF-8';
        //$mailer->Subject = Yii::t('demo', 'Yii rulez!');
        $mailer->Subject = $this->_subject;
        //$mailer->Body = $this->_body;
        $mailer->MsgHTML($this->_body);


        if (!$mailer->Send()) {

            //Yii::app()->user->setFlash('mail', $this->_error);
            Yii::app()->user->setFlash('mail', $mailer->ErrorInfo);
        } else {
            Yii::app()->user->setFlash('mail', $this->_sent);
        }
    }

    /**
     * populate the $_data attribute with the user informations
     * @param UserGroupsUser $model the user that is goint to receive the email
     */
    protected function extractUserData(UserGroupsUser $model) {
        //$this->_to = "{$model->username} <{$model->email}>";
        $this->_to = "{$model->email}";

        //$link = 'https://' . $_SERVER['HTTP_HOST'] . Yii::app()->homeUrl . 'userGroups/user/activate';
        $link = Yii::app()->params['hostName'] . Yii::app()->homeUrl . 'userGroups/user/activate';
        $link2 = "<a href='$link'>$link</a>";
        $full_link = $link . '?UserGroupsUser[username]=' . $model->username . '&UserGroupsUser[activation_code]=' . $model->activation_code;
        $full_link2 = "<a href='$full_link'>$full_link</a>";
        $this->_data = array(
            '{email}' => $model->email,
            '{username}' => $model->username,
            '{activation_code}' => $model->activation_code,
            '{link}' => $link2,
            '{full_link}' => $full_link2,
            '{website}' => Yii::app()->name,
        );
    }

    /**
     * return the default UGMailMessage object
     * @param string $message the kind of mail message desired
     * @return UGMailMessage
     */
    protected function defaultMailMessage($message) {
        switch ($message) {
            case self::ACTIVATION:
                return new UGMailActivation;
                break;
            case self::PASS_RESET:
                return new UGMailPassReset;
                break;
            case self::INVITATION:
                return new UGMailInvitation;
                break;
        }
    }

}

/**
 * the interface that every mail message has to implement
 * @author Nicola Puddu
 * @package userGroups
 */
interface UGMailMessage {

    /**
     * @param string $admin_mail the application adminMail parameter
     * @return string the email headers
     */
    public function mailHeader($admin_mail);

    /**
     * @param array $data the data array that can be used by Yii::t()
     * @return string the email subject
     */
    public function mailSubject($data);

    /**
     * @param array $data the data array that can be used by Yii::t()
     * @return string the email body
     */
    public function mailBody($data);

    /**
     * @param array $data the data array that can be used by Yii::t()
     * @return string the email signature
     */
    public function mailSignature($data);

    /**
     * @param array $data the data array that can be used by Yii::t()
     * @return string the flash message to use in case of no errors
     */
    public function mailSuccess($data);

    /**
     * @param array $data the data array that can be used by Yii::t()
     * @return string the flash message to use in case of errors
     */
    public function mailError($data);
}

/**
 * the mail message that will be sent to user that have to be activated
 * @author Nicola Puddu
 * @package userGroups
 */
class UGMailActivation implements UGMailMessage {

    /**
     * @see UGMailMessage::mailHeader()
     */
    public function mailHeader($admin_mail) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . Yii::app()->name . ' <' . $admin_mail . '>';
        return $headers;
    }

    /**
     * @see UGMailMessage::mailSubject()
     */
    public function mailSubject($data) {
        return Yii::t('userGroupsModule.mail', 'account activation');
    }

    /**
     * @see UGMailMessage::mailBody()
     */
    public function mailBody($data) {
        var_dump($data);
        die();
        return Yii::t('userGroupsModule.mail', 'To Activate your account please click on this link:<br/>{full_link}
					<br/>or you can go to this address<br/>{link}<br/>and insert in the form the following data<br/>username: <b>{username}</b>
					<br/>activation code: <b>{activation_code}</b><br/>', $data);
    }

    /**
     * @see UGMailMessage::mailSignature()
     */
    public function mailSignature($data) {
        return NULL;
    }

    /**
     * @see UGMailMessage::mailSuccess()
     */
    public function mailSuccess($data) {
        return Yii::t('userGroupsModule.general', 'The activation email was succefully sent to {email}', $data);
    }

    /**
     * @see UGMailMessage::mailError()
     */
    public function mailError($data) {
        return Yii::t('userGroupsModule.general', 'Impossible send email to the address {email}', $data);
    }

}

/**
 * the mail message that will be sent to user that requested a password reset
 * @author Nicola Puddu
 * @package userGroups
 */
class UGMailPassReset implements UGMailMessage {

    /**
     * @see UGMailMessage::mailHeader()
     */
    public function mailHeader($admin_mail) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . Yii::app()->name . ' <' . $admin_mail . '>';
        return $headers;
    }

    /**
     * @see UGMailMessage::mailSubject()
     */
    public function mailSubject($data) {
        return Yii::t('userGroupsModule.mail', 'password reset request');
    }

    /**
     * @see UGMailMessage::mailBody()
     */
    public function mailBody($data) {
        return Yii::t('userGroupsModule.mail', 'You requested a password reset.<br/> Your account will be disabled
				until you set a new password.<br/> To reactivate your account and set the new password please click on this link:<br/>{full_link}
					<br/>or you can go to this address<br/>{link}<br/>and insert in the form the following data<br/>username: <b>{username}</b>
					<br/>activation code: <b>{activation_code}</b><br/>', $data);
    }

    /**
     * @see UGMailMessage::mailSignature()
     */
    public function mailSignature($data) {
        return NULL;
    }

    /**
     * @see UGMailMessage::mailSuccess()
     */
    public function mailSuccess($data) {
        return Yii::t('userGroupsModule.general', 'An email containing the instruction to reset your password has been sent to your email address: {email}', $data);
    }

    /**
     * @see UGMailMessage::mailError()
     */
    public function mailError($data) {
        return Yii::t('userGroupsModule.general', 'Impossible send email to the address {email}', $data);
    }

}

/**
 * the mail message that will be sent to user that have been invited to join the application
 * @author Nicola Puddu
 * @package userGroups
 */
class UGMailInvitation implements UGMailMessage {

    /**
     * @see UGMailMessage::mailHeader()
     */
    public function mailHeader($admin_mail) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . Yii::app()->name . ' <' . $admin_mail . '>';
        return $headers;
    }

    /**
     * @see UGMailMessage::mailSubject()
     */
    public function mailSubject($data) {
        return Yii::t('userGroupsModule.mail', 'invitation to {website}', $data);
    }

    /**
     * @see UGMailMessage::mailBody()
     */
    public function mailBody($data) {
        return Yii::t('userGroupsModule.mail', 'You have been invited to join {website}.<br/>
					To activate your account and set the new password please click on this link:<br/>{full_link}
					<br/>or you can go to this address<br/>{link}<br/>and insert in the form the following data<br/>username: <b>{username}</b>
					<br/>activation code: <b>{activation_code}</b><br/>
					You will be able to change the username when you activate the account', $data);
    }

    /**
     * @see UGMailMessage::mailSignature()
     */
    public function mailSignature($data) {
        return NULL;
    }

    /**
     * @see UGMailMessage::mailSuccess()
     */
    public function mailSuccess($data) {
        return Yii::t('userGroupsModule.general', 'An invitation email was sent to the address {email}', $data);
    }

    /**
     * @see UGMailMessage::mailError()
     */
    public function mailError($data) {
        return Yii::t('userGroupsModule.general', 'Impossible send email to the address {email}', $data);
    }

}
