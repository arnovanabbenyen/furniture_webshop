<?php

include_once(__DIR__ . "/../classes/Review.php");

if(empty($_POST)){
    try{
        $review = new Review();
        $review->setComment($_POST['comment']);
        $review->setRating($_POST['rating']);
        $review->setCreated_at(date('Y-m-d H:i:s'));
        $review->setProduct_id($_POST['product_id']);
        $review->setUser_id($_POST['user_id']);
        $review->save();
        $first_name = $review->getUserById($_POST['user_id']);
        
        $response = [
            'status' => 'success',
            'body' => htmlspecialchars($review->getComment()),
            'rating' => $review->getRating(),
            'created_at' => $review->getCreated_at(),
            'user_id' => $review->getUser_id(),
            'first_name' => $first_name,
            'message' => 'Review added successfully'
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    catch(Exception $e){
        $error = $e->getMessage();
        error_log($error); // Log de foutmelding
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $error]);
    }
}