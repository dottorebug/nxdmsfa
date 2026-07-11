# NXDMSFA

> **N**extcloud **X** **D**MS **F**ramework **A**pp - A host-agnostic PHP application for Nextcloud (and other hosts in the future).

---

## Overview

NXDMSFA is designed as a **host-agnostic PHP application** that can run in **Nextcloud** (v34+) and potentially other host environments (e.g., other CMS or frameworks) in the future. The core logic is decoupled from the host using a **Host Adapter Pattern**, making it easy to add support for new hosts.

### Key Features
- ✅ **Nextcloud 34+** compatible
- ✅ **Host Abstraction Layer** (`HostAdapterInterface`)
- ✅ **Dependency Injection** (Nextcloud's DI container)
- ✅ **Extensible** for other hosts (e.g., WordPress, Drupal, standalone PHP)

---

## Structure

```
nxdmsfa/
├── appinfo/
│   ├── info.xml          # Nextcloud app metadata
│   └── routes.php        # Route definitions
├── lib/
│   ├── AppInfo/
│   │   └── Application.php  # App initialization (replaces app.php)
│   ├── HostAdapter/
│   │   ├── HostAdapterInterface.php  # Host abstraction interface
│   │   └── NextcloudHostAdapter.php  # Nextcloud implementation
│   └── Controller/
│       └── HelloController.php  # Example controller
├── composer.json         # Autoloading & dependencies
├── .gitignore
└── README.md
```

---

## Host Abstraction

The **`HostAdapterInterface`** provides a unified API for host-specific operations (e.g., user sessions, logging, requests). This allows the app to work in different environments without changing the core logic.

### Interface Methods
| Method | Description | Example |
|--------|-------------|---------|
| `getCurrentUserId()` | Returns the current user ID | `"admin"` |
| `getHostName()` | Returns the host name | `"nextcloud"` |
| `log()` | Logs a message | `log("Error!", "error")` |
| `getRequestUrl()` | Returns the current URL | `"/apps/nxdmsfa/hello"` |
| `isLoggedIn()` | Checks if user is logged in | `true`/`false` |

### Adding a New Host
1. Implement `HostAdapterInterface` for the new host (e.g., `WordPressHostAdapter`).
2. Register the adapter in the host's DI container.
3. The app logic remains unchanged!

---

## Installation (Nextcloud)

### Manual Installation
1. Clone this repo into your Nextcloud's `apps/` directory:
   ```bash
   git clone https://github.com/dottorebug/nxdmsfa.git /var/www/nextcloud/apps/nxdmsfa
   ```
2. Enable the app via Nextcloud's admin panel or CLI:
   ```bash
   sudo -u www-data php occ app:enable nxdmsfa
   ```
3. Run `composer install` (if dependencies are added later):
   ```bash
   cd /var/www/nextcloud/apps/nxdmsfa
   composer install
   ```

### Development
1. Symlink the app into Nextcloud (for live reloading):
   ```bash
   ln -s /path/to/nxdmsfa /var/www/nextcloud/apps/nxdmsfa
   ```
2. Enable debug mode in Nextcloud's `config.php`:
   ```php
   'debug' => true,
   ```

---

## Usage

### Example: Using the Host Adapter in a Controller
```php
use OCA\Nxdmsfa\HostAdapter\HostAdapterInterface;

class MyController extends Controller
{
    private HostAdapterInterface $hostAdapter;

    public function __construct(HostAdapterInterface $hostAdapter)
    {
        $this->hostAdapter = $hostAdapter;
    }

    public function myMethod(): JSONResponse
    {
        $userId = $this->hostAdapter->getCurrentUserId();
        $this->hostAdapter->log("User $userId called myMethod");
        
        return new JSONResponse(['user' => $userId]);
    }
}
```

### Testing the App
After enabling the app, visit:
```
https://your-nextcloud.example.com/apps/nxdmsfa/hello
```
Expected output:
```json
{
    "message": "Hello from NXDMSFA!",
    "host": "nextcloud",
    "user_id": "admin",
    "is_logged_in": true,
    "request_url": "/apps/nxdmsfa/hello"
}
```

---

## License

This project is licensed under the **AGPL-3.0-or-later** license. See [LICENSE](LICENSE) for details.

---

## Contributing

1. Fork the repository.
2. Create a feature branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a Pull Request.
