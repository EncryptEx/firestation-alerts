<p align="center"><img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pinclipart.com%2Fpicdir%2Fbig%2F234-2340249_fire-station-icon-clipart.png&f=1&nofb=1" alt="Firestation" height="60"/></p>
<h1 align="center">Firestation Alerts</h1>
<p align="center">The definitive platform to handle and montior all incoming firestation alerts.</p>
<p align="center">
<img src="https://img.shields.io/github/languages/code-size/EncryptEx/firestation-alerts"/>
<img src="https://img.shields.io/github/languages/top/EncryptEx/firestation-alerts"/>
<img src="https://tokei.ekzhang.com/b1/github/EncryptEx/firestation-alerts"/>
<img src="https://img.shields.io/github/last-commit/EncryptEx/firestation-alerts"/>
</p>

A platform part of a [Research Project](##Research%20Project) (TR of 2nd Batxillerat in Catalunya). The functionality is pretty simple to understand: When endpoint `/api/newNotification.php` is requested with correct credentials and passing the [necessary parameters](##Api%20Parameters), it will pop up an alert to all connected clients whithin the country affected. In case that the coordinates point to international waters, the alert will pop up in all clients with no restriction at all.

---

## Architecture

This project is using

- PHP
- MySQL (pdo conections)
- Composer, to use:
  - vlucas/**phpdotenv** (credentials management)
  - phpmailer/**phpmailer** (SMTP email library)
  - cboden/**ratchet** (WebSocket PHP library)
- Bootstrap 5
- Material Symbols and Icons
- FREE APIs used:
  - Maps API: [Open Street Map](https://wiki.openstreetmap.org/) and [Leaftlet](https://wiki.openstreetmap.org/wiki/Leaflet)
  - Street info trough Geocoords, ([Geocode.maps.co](https://geocode.maps.co/))

---

## Demo

This is only a little part of the final practical part of the research project. For more information, I strongly recommend to check out the entire research paper: [PDF link](##Research%20Project)

---

## Installation

The installation process will be described in the [PDF](##Research%20Project)

---

## Research Project

Link to Research Paper is comming soon and will be available in few weeks (project not finished yet).

---

### Suggestions or questions

If you feel that something is wrong in this README file or you need help while setting up this project, feel free to contact or open a [GitHub Issue](https://github.com/EncryptEx/firestation-alerts/issues/new).

---

<p align="center"><a href="https://github.com/EncryptEx/hammer/"><img src="http://randojs.com/images/barsSmallTransparentBackground.gif" alt="Animated footer bars" width="100%"/></a></p>
