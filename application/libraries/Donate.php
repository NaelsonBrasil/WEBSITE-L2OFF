<?php

/**
 * Created by PhpStorm.
 * User: vipcriativo.web@gmail.com
 * Date: 11/17/2018
 * Time: 10:47 AM
 */

class Donate
{
    private $db;
    private $tbDonated = 'donated';
    private $tbDonate = 'item_donate';
    private $tbOrder = 'donate_order';
    private $upload = 'uploaded/icon/';

    function __construct()
    {
        $CI = get_instance();
        $this->db = $CI->load->database('custom', true);
    }

    public function setItem($itemId, $idUser, $userName, $itemName, $itemPrice, $itemBonus, $iconName, $dateTime)
    {
        //Token Protection flooding
        $data = array(
            'item_id' => $itemId,
            'user_id' => $idUser,
            'user_name' => $userName,
            'item_name' => $itemName,
            'item_price' => $itemPrice,
            'item_bonus' => $itemBonus,
            'icon_name' => $iconName,
            'date_time' => $dateTime,
            'token' => md5(rand(1, 99999)));

        try {
            $this->db->insert($this->tbDonate, $data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function setOrderItem($itemId, $userId, $userName, $itemName, $iconName, $amount, $total, $dateTime)
    {
        //Token Protection flooding
        $data = array(
            'item_id' => $itemId,
            'user_id' => $userId,
            'user_name' => $userName,
            'item_name' => $itemName,
            'icon_name' => $iconName,
            'amount' => $amount,
            'total' => $total,
            'date_time' => $dateTime,
            'code_reference' => "ref".md5(rand(1, 99999)),
            'token' => md5(rand(1, 99999))
        );

        try {
            $this->db->insert($this->tbOrder, $data);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function getItem($tableName, $id = null)
    {
        switch ($tableName) {

            case "order":
                $query = $this->db->get_where($this->tbOrder, array('user_id' => $id));
                return $query->result_array();
                break;

            case "register":
                $query = $this->db->get($this->tbDonate);
                return $query->result_array();
                break;

            default:
                show_error("Error exception create order or register item");
        }

        return 0;
    }

    public function getCountItem($tableName, $id = null)
    {

        switch ($tableName) {

            case "order":
                $query = $this->db->get_where($this->tbOrder, array('user_id' => $id));
                if ($query->num_rows() > 0) {
                    return $query->num_rows();
                } else {
                    return 0;
                }
                break;
            case "register":
                $query = $this->db->get($this->tbDonate);
                if ($query->num_rows() > 0) {
                    return $query->num_rows();
                } else {
                    return 0;
                }
                break;

            default:
                show_error("Error exception Count Item register or order!");
        }

        return 0;

    }

    //Polymorphism
    public function delete($tableName, $token, $idOrder = null, $idUser = null) : bool
    {

        switch ($tableName) {

            case "order":

                $this->db->where('token', $token);
                $this->db->where('id', $idOrder);
                $this->db->where('user_id', $idUser);
                try {
                    $this->db->delete($this->tbOrder);
                    return true;
                } catch (Exception $e) {
                    return false;
                }
                break;

            case "register":
                $unLik = $this->upload . $this->getIconName($token);
                @unlink($unLik);
                $this->db->where('token', $token);
                try {
                    $this->db->delete($this->tbDonate);
                    return true;
                } catch (Exception $e) {
                    return false;
                }

            default:
                show_error("Error exception Count Item register or order!");
        }

        return false;
    }

    public function getDonate($idOrder, $idUser)
    {
        $this->db->where('id', $idOrder);
        $this->db->where('user_id', $idUser);
        $query = $this->db->get($this->tbOrder);
        if ($query->num_rows() > 0) {

            return $query->result_array();

        }

        return 0;
    }


    public function getPrice($itemName)
    {

        $query = $this->db->select("item_price")->where('item_name', $itemName)->get($this->tbDonate);

        if ($query->num_rows() > 0) {

            return $query->row()->item_price;

        }

        return 0;
    }

    public function getBonus($itemName)
    {

        $query = $this->db->select("item_bonus")->where('item_name', $itemName)->get($this->tbDonate);
        if ($query->num_rows() > 0) {

            return $query->row()->item_bonus;

        }

        return 0;
    }

    public function getIconName($token)
    {
        $this->db->select("icon_name");
        $query = $this->db->get_where($this->tbDonate, array('token' => $token));
        foreach ($query->result() as $row) if (!empty($row->icon_name)) return $row->icon_name;
        else return 0;

        return 0;
    }


    public function setDonated($itemId, $userId, $itemName, $iconName, $quantity, $subTotal, $dateTime)
    {

        if ($this->verifyItemDonated($userId, $itemId) === true) {

            try {

                $addBonus = $this->getBonus($itemName);
                $amountBefore = $this->getCountItemDonated($userId, $itemId);
                $mergeQuantity = $quantity + $amountBefore + $addBonus;
                $this->updateItemDonate($userId,$itemId,$mergeQuantity); 
                $this->setHistoryDonated($userId,$itemId,$itemName,$subTotal,$quantity,$amountBefore,$mergeQuantity,$dateTime);

             return true;
            } catch (Exception $e) {return false;}

        } else {

            $addBonus = $this->getBonus($itemName);

           //Token Protection flooding
           $mergeQuantity = $quantity + $addBonus;
            $data = array(
                'item_id' => $itemId,
                'user_id' => $userId,
                'item_name' => $itemName,
                'icon_name' => $iconName,
                'amount' => $quantity + $addBonus,
                'total' => $subTotal,
                'date_time' => $dateTime,
                'token' => md5(rand(1, 99999))
            );

            try {
                $this->db->insert($this->tbDonated, $data);
                $this->setHistoryDonated($userId,$itemId,$itemName,$subTotal,$quantity,null,$mergeQuantity,$dateTime);

                return true;

            } catch (Exception $e) {

                return false;

            }

        }

    }
   
    public function updateItemDonate($userId,$itemId,$qt){

        $this->db->query("UPDATE donated SET amount = '$qt' WHERE user_id = '$userId' AND item_id = '$itemId' ");

    }

    public function getDonated($idUser) : array
    {

        $this->db->where('user_id', $idUser);
        $query = $this->db->get($this->tbDonated);
        return $query->result_array();

    }


    public function verifyItemDonated($userId, $itemId) : bool
    {
        $this->db->where('user_id', $userId);
        $this->db->where('item_id', $itemId);
        $query = $this->db->get($this->tbDonated);

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }

    }

    public function getCountItemDonated($userId, $itemId) : int
    {
        $this->db->where('user_id', $userId);
        $this->db->where('item_id', $itemId);
        $query = $this->db->get($this->tbDonated);

        if($query->num_rows() > 0) {
            return $query->row()->amount;
        }else {
            return 0;
        }
    }

    public function getCountRegisterDonated($userId) : int
    {

        $query = $this->db->get_where($this->tbDonated, array('user_id' => $userId));

        if ($query->num_rows() > 0) {

            return $query->num_rows();

        } else {
            return 0;
        }

    }


    public function setHistoryDonated($userId,$itemId,$itemName,$itemPrice,$amount_donated,$amount_before = null,$amountAfter,$dateTime)
    {
            
        $data = array(
            'user_id' => $userId,
            'item_id' => $itemId,
            'item_name' => $itemName,
            'item_price' => $itemPrice,
            'amount_donated' => $amount_donated,
            'amount_before' => $amount_before,
            'amount_after' => $amountAfter,
            'date_time' => $dateTime
        );

        try {
            $this->db->insert('history_donated', $data);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function setHistoryTransfer($userId,$itemId,$charId,$quantity,$dateTime)
    {
            
        $data = array(
            'user_id' => $userId,
            'item_id' => $itemId,
            'char_id' => $charId,
            'amount' => $quantity,
            'date_time' => $dateTime);

        try {
            $this->db->insert('history_transfer', $data);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }


    public function getCountOrders($idUser) {
        
     $this->db->select("*");
     $this->db->where('user_id',$idUser);
     $query = $this->db->get($this->tbOrder);
     return $query->num_rows();
    }
}