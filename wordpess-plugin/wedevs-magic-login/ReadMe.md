# WeDevs Magic Login

---

Instructions:

- **Important:** Change the server api endpoint in `src/Plugin.php` file according to your backend server where from you want to verify the magic login. In this plugin use included `'server (DNS Manager)'` as a Backend Server project.
- Install the plugin in your WordPress site.
- Activate the plugin.
- Go to the `WeDevs Magic Login` menu in the admin panel (Settings -> WeDevs Magic Login).
- Set the `Secret Key` from the `Backend Server`.
- Save the settings.
- Now you can log in to your WordPress site using the `Go To Dashboard` button in the `Backend Server`.

---

Features:
- [x] Update Secret Key from Admin Panel
- [x] Validate magic login using hashing and verify token from the `Backend Server`
