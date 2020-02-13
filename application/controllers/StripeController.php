<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class StripeController extends CI_Controller {
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
    }
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index()
    {
		/* get_print($this->input->post()); */
        $this->load->view('my_stripe');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function stripePost()
    {
		$amt = $this->input->post('amt');
		$stripe_mode = $this->auto_model->getFeild('stripe_mode','setting','id',1);
		if($stripe_mode=='DEMO'){
			$stripe_secret = get_option_value('demo_stripe_secret');
		} else {
			$stripe_secret = get_option_value('live_stripe_secret');
		}
		$stripe_token = $this->input->post('stripeToken');
		
		require_once(APATH.'application/libraries/stripe-php/init.php');
       
        \Stripe\Stripe::setApiKey($stripe_secret);
		
        $charge = \Stripe\Charge::create ([
                "amount" => 100 * $amt,
                "currency" => "usd",
                "source" => $stripe_token,
                "description" => "Add Fund in Freelancer near me through stripe" 
        ]);
		$chargeJson = $charge->jsonSerialize();
		/* get_print($chargeJson); */
		if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
		{
			$user = $this->session->userdata('user');
			$user_id = $user[0]->user_id;
			$amount = $chargeJson['amount']/100;
			$mc_gross = round(($amount + floatval(0.30)) / (1 - floatval(2.9) / 100),2);//15.75
			$payment_fee = $mc_gross-$amount;//.75
			
			$this->load->model('myfinance/transaction_model');
			/* $msg = json_encode($chargeJson);
			file_put_contents('paypal.log', $msg); */
			$acc_balance=$this->auto_model->getFeild('acc_balance','user','user_id',$user_id);
			$user_wallet_id = get_user_wallet($user_id);
			$acc_balance=get_wallet_balance($user_wallet_id);
			
            $post['status']="Y";
            $post['paypal_transaction_id']=$chargeJson['balance_transaction'];
            $post['amount']=($amount-$payment_fee);
            $post['transction_type']="CR";
            $post['transaction_for']="Add Fund";
            $post['user_id']=$user_id;
            $post['transction_date']=date("Y-m-d H:i:s");
			
		    // transaction insert
		    $new_txn_id = $this->transaction_model->add_transaction(ADD_FUND_PAYPAL,  $user_id);
            if($user_id && $new_txn_id){ 
				// Affected transaction row and wallet
				$user_wallet_id = get_user_wallet($user_id);

				// credit main wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'credit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through stripe'));

				// transfer money from main wallet to user wallet 
				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => MAIN_WALLET, 'debit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through stripe'));

				$this->transaction_model->add_transaction_row(array('txn_id' => $new_txn_id, 'wallet_id' => $user_wallet_id, 'credit' => $post['amount'], 'ref' => $post['paypal_transaction_id'], 'info' => 'Fund added through stripe'));

				wallet_add_fund($user_wallet_id, $post['amount']);

				check_wallet($user_wallet_id,  $new_txn_id);
				/* echo base_url().'myfinance/payment_confirm/'.$chargeJson['id']; die; */
				redirect(base_url().'myfinance/payment_confirm/'.$user_id);
            }
        } else {
			redirect(base_url().'myfinance/payment_cancel/');
		}
    }
}