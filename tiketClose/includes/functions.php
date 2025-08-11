<?php
require_once 'db.php';

function getAllTickets() {
    return getDB();
}

function getTicketById($id) {
    $tickets = getDB();
    foreach ($tickets as $ticket) {
        if ($ticket['id'] == $id) {
            return $ticket;
        }
    }
    return null;
}

function createTicket($data) {
    $tickets = getDB();
    $data['id'] = uniqid();
    $data['created_at'] = date('Y-m-d H:i:s');
    $tickets[] = $data;
    saveDB($tickets);
    return $data['id'];
}

function updateTicket($id, $data) {
    $tickets = getDB();
    foreach ($tickets as &$ticket) {
        if ($ticket['id'] == $id) {
            $ticket = array_merge($ticket, $data);
            $ticket['updated_at'] = date('Y-m-d H:i:s');
            saveDB($tickets);
            return true;
        }
    }
    return false;
}

function deleteTicket($id) {
    $tickets = getDB();
    foreach ($tickets as $key => $ticket) {
        if ($ticket['id'] == $id) {
            unset($tickets[$key]);
            saveDB(array_values($tickets));
            return true;
        }
    }
    return false;
}
?>