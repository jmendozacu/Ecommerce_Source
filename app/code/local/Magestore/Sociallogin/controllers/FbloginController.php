<?php
class Magestore_Sociallogin_FbloginController extends Mage_Core_Controller_Front_Action{

    public function loginAction() {
		Mage::log(__LINE__, null, 'facebook.log', true);
		$isAuth = $this->getRequest()->getParam('auth');
		$facebook = Mage::getModel('sociallogin/fblogin')->newFacebook();
		$userId = $facebook->getUser();
		Mage::log(__LINE__, null, 'facebook.log', true);
		Mage::log(__LINE__, null, 'facebook.log', true);
		if($isAuth && !$userId && $this->getRequest()->getParam('error_reason') == 'user_denied'){
			Mage::log(__LINE__, null, 'facebook.log', true);
			echo("<script>window.close()</script>");
		}elseif ($isAuth && !$userId){
			$loginUrl = $facebook->getLoginUrl(array('scope' => 'email'));
			Mage::log($loginUrl, null, 'facebook.log', true);
			echo "<script type='text/javascript'>top.location.href = '$loginUrl';</script>";

			exit;
		}
		Mage::log(__LINE__, null, 'facebook.log', true);
 		$user = Mage::getModel('sociallogin/fblogin')->getFbUser();
		Mage::log($user, null, 'facebook.log', true);
		Mage::log($user, null, 'facebook.log', true);
		if ($isAuth && $user){
			$store_id = Mage::app()->getStore()->getStoreId();//add
			$website_id = Mage::app()->getStore()->getWebsiteId();//add

			$data =  array('firstname'=>$user['first_name'], 'lastname'=>$user['last_name'], 'email'=>$user['email']);
			if($data['email']){
				$customer = Mage::helper('sociallogin')->getCustomerByEmail($data['email'],$website_id );//add edition
				if(!$customer || !$customer->getId()){
					//Login multisite
					$customer = Mage::helper('sociallogin')->createCustomerMultiWebsite($data, $website_id, $store_id );
					if(Mage::getStoreConfig('sociallogin/fblogin/is_send_password_to_customer')){
						$customer->sendPasswordReminderEmail();
					}
				}
					// fix confirmation
				if ($customer->getConfirmation())
				{
					try {
						$customer->setConfirmation(null);
						$customer->save();
					}catch (Exception $e) {
					}
				}
				Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
				die("<script type=\"text/javascript\">if(navigator.userAgent.match('CriOS')){window.location.href=\"".$this->_loginPostRedirect()."\";}else{try{window.opener.location.href=\"".$this->_loginPostRedirect()."\";}catch(e){window.opener.location.reload(true);} window.close();}</script>");   
			}else{
				Mage::getSingleton('core/session')->addError('You provided a email invalid!');			
				die("<script type=\"text/javascript\">try{window.opener.location.reload(true);}catch(e){window.opener.location.href=\"".Mage::app()->getStore()->getBaseUrl()."\"} window.close();</script>");
			}
		}
	}
	protected function _loginPostRedirect()
    {
//        $session = Mage::getSingleton('customer/session');
//
//        if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::app()->getStore()->getBaseUrl()) {
//            // Set default URL to redirect customer to
//            $session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());
//            
//        } else if ($session->getBeforeAuthUrl() == Mage::helper('customer')->getLogoutUrl()) {
//            $session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());
//        } else {
//            if (!$session->getAfterAuthUrl()) {
//                $session->setAfterAuthUrl($session->getBeforeAuthUrl());
//            }
//            if ($session->isLoggedIn()) {
//                $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
//            }
//        }
//		
//        return $session->getBeforeAuthUrl(true);
            $selecturl= Mage::getStoreConfig(('sociallogin/general/select_url'),Mage::app()->getStore()->getId());
	if($selecturl==0) return Mage::getUrl('customer/account');
	if($selecturl==1) return Mage::getUrl('checkout/cart');
	if($selecturl==2) return Mage::getUrl();
	if($selecturl==3) return $_SESSION["socialogin_currentpage"];
	if($selecturl==4) return Mage::getStoreConfig(('sociallogin/general/custom_page'),Mage::app()->getStore()->getId());
    }

	
}