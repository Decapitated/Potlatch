<?php
namespace App\Controllers;

use Exception;

class Comment extends BaseController {
    public function comment(){
        if(isset($this->session->user)){ // If signed in.
            helper(['url', 'user']);
            // Get and validate inputs and hidden inputs.
            $reply_id = $this->request->getVar('reply_id', FILTER_VALIDATE_INT);
            $item_id = $this->request->getVar('item_id', FILTER_VALIDATE_INT);
            $comment = $this->request->getVar('comment', FILTER_SANITIZE_STRING);
            $itemCommentModel = new \App\Models\Comment();
            $data = [
                'reply_id' => ($reply_id)? $reply_id : NULL,
                'item_id' => $item_id,
                'user_id' => $this->session->user->id,
                'comment' => $comment
            ];
            //Redirect back to auction page if submission is succesful. 
            if($itemCommentModel->insert($data)){
                return redirect()->to('/auction/'.$item_id);
            }else{
                throw new \CodeIgniter\Exceptions\PageNotFoundException();
            }
        }else{
            return redirect()->to('/login');
        }
    }

    public function loadReplies($reply_id) {
        $db = db_connect();
        $replies = $db->query('SELECT c.id, c.comment, c.timestamp, u.first_name, u.last_name
                            FROM comment c LEFT JOIN user u ON u.id = c.user_id WHERE c.reply_id = ?', [$reply_id])->getResultArray();
        echo json_encode($replies);
    }
}
?>