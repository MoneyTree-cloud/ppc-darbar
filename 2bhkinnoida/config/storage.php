<?php
/**
 * Real Estate Chatbot - File-based Storage Functions
 * This file provides functions for storing and retrieving data using files instead of a database.
 * 
 * Note: These functions are designed to be used when STORAGE_TYPE is set to 'file'.
 * Some functions have the same names as functions in database.php but they are not loaded
 * at the same time, so there is no conflict.
 */

// Only define these functions if they don't already exist (coming from database.php)
if (!function_exists('getFileStorageDirectory')) {
    /**
     * Get the file storage directory path
     * 
     * @return string Path to the file storage directory
     */
    function getFileStorageDirectory() {
        return DATA_DIR;
    }
}

// We won't redefine functions that already exist in database.php
// Instead, we'll check if they exist first and only define them if they don't

// No need to redefine saveLeadToFile, getLeadsFromFile, getLeadFromFile or updateLeadStatusInFile
// as they already exist in database.php

if (!function_exists('getLeadByIdFromFile')) {
    /**
     * Get a single lead by ID from file storage
     * 
     * @param string $leadId The ID of the lead to retrieve
     * @return array|null Lead data or null if not found
     */
    function getLeadByIdFromFile($leadId) {
        $leadFile = DATA_DIR . '/leads/' . $leadId . '.json';
        
        if (file_exists($leadFile)) {
            $leadData = json_decode(file_get_contents($leadFile), true);
            return $leadData ?: null;
        }
        
        return null;
    }
}

if (!function_exists('searchLeadsInFile')) {
    /**
     * Search leads in file storage
     * 
     * @param string $searchTerm Term to search for
     * @return array Array of matching lead data
     */
    function searchLeadsInFile($searchTerm) {
        $results = [];
        $leads = getLeadsFromFile();
        
        $searchTerm = strtolower($searchTerm);
        
        foreach ($leads as $lead) {
            // Search in name, phone, and requirements fields
            if (stripos($lead['name'], $searchTerm) !== false ||
                stripos($lead['phone'], $searchTerm) !== false ||
                (isset($lead['requirements']) && stripos($lead['requirements'], $searchTerm) !== false)) {
                $results[] = $lead;
            }
        }
        
        return $results;
    }
}

if (!function_exists('getLeadStatsFromFile')) {
    /**
     * Get statistics about leads from file storage
     * 
     * @return array Array of lead statistics
     */
    function getLeadStatsFromFile() {
        $leads = getLeadsFromFile();
        
        $stats = [
            'total_leads' => count($leads),
            'new_leads' => 0,
            'contacted_leads' => 0,
            'converted_leads' => 0,
            'closed_leads' => 0
        ];
        
        foreach ($leads as $lead) {
            $status = $lead['status'] ?? 'new';
            switch ($status) {
                case 'new':
                    $stats['new_leads']++;
                    break;
                case 'contacted':
                    $stats['contacted_leads']++;
                    break;
                case 'converted':
                    $stats['converted_leads']++;
                    break;
                case 'closed':
                    $stats['closed_leads']++;
                    break;
            }
        }
        
        // Calculate conversion rate
        $stats['conversion_rate'] = $stats['total_leads'] > 0 ? 
            round(($stats['converted_leads'] / $stats['total_leads']) * 100, 2) : 0;
        
        return $stats;
    }
}