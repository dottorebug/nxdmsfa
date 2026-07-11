<?php
/**
 * @package nxdmsfa
 * @copyright 2024 dottorebug
 * @license AGPL-3.0-or-later
 */

namespace OCA\Nxdmsfa\HostAdapter;

/**
 * Interface für Host-Abstraktion.
 * Ermöglicht die Nutzung der App in verschiedenen Host-Umgebungen (Nextcloud, etc.).
 */
interface HostAdapterInterface
{
    /**
     * Gibt den aktuellen Benutzernamen zurück.
     * @return string|null Benutzername oder null, wenn nicht angemeldet.
     */
    public function getCurrentUserId(): ?string;

    /**
     * Gibt die aktuelle Host-Umgebung zurück (z. B. 'nextcloud').
     * @return string Host-Name.
     */
    public function getHostName(): string;

    /**
     * Loggt eine Nachricht.
     * @param string $message Nachricht.
     * @param string $level Log-Level (z. B. 'info', 'error', 'debug').
     */
    public function log(string $message, string $level = 'info'): void;

    /**
     * Gibt die aktuelle Request-URL zurück.
     * @return string URL.
     */
    public function getRequestUrl(): string;

    /**
     * Prüft, ob der aktuelle Benutzer angemeldet ist.
     * @return bool True, wenn angemeldet.
     */
    public function isLoggedIn(): bool;
}
