/**
 * Final project
 * This is a final project for the course of Web Development
 *
 * The version of the OpenAPI document: 1.0.0
 * 
 *
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */
import { Discipline } from './discipline';


/**
 * TournamentDetails model
 */
export interface TournamentDetails { 
    /**
     * Name of the tournament
     */
    name: string;
    /**
     * Time of the tournament
     */
    time: string;
    /**
     * Registration time of the tournament
     */
    registration_time: string;
    /**
     * Max participants of the tournament
     */
    max_participants: number;
    /**
     * Latitude of the tournament
     */
    latitude: number;
    /**
     * Longitude of the tournament
     */
    longitude: number;
    /**
     * Discipline id of the tournament
     */
    discipline_id: number;
    /**
     * Id
     */
    id: number;
    discipline: Discipline;
    /**
     * Number of ranked participants
     */
    numOfRankedParticipants?: number;
}

