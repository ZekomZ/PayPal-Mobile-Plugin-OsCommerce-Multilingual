<h4>
  <a href="#english"><img src="https://raw.github.com/ontech/PayPal-Mobile-Plugin-Zen-Cart-Multilingual/master/mobile/images/flags/gb.png" alt="English" /> 
    English
  </a> &nbsp;
  <a href="#french"><img src="https://raw.github.com/ontech/PayPal-Mobile-Plugin-Zen-Cart-Multilingual/master/mobile/images/flags/fr.png" alt="Français" />
    Français
  </a>  &nbsp;
  <a href="#italian"><img src="https://raw.github.com/ontech/PayPal-Mobile-Plugin-Zen-Cart-Multilingual/master/mobile/images/flags/it.png" alt="Italian" />
    Italian
  </a>  &nbsp;
  <a href="#spanish"><img src="https://raw.github.com/ontech/PayPal-Mobile-Plugin-Zen-Cart-Multilingual/master/mobile/images/flags/es.png" alt="Espanol" />
    Espanol
  </a>  &nbsp;  
  <a href="#dutch"><img src="https://raw.github.com/ontech/PayPal-Mobile-Plugin-Zen-Cart-Multilingual/master/mobile/images/flags/nl.png" alt="Dutch" />
    Dutch
  </a> 
</h4> 

<a name="dutch">Dutch</a>
-------
Installatie-instructies voor de plug-in voor PayPal Mobiel
==============================================
<sup> Met technologie van [ezimerchant](http://ezimerchant.com/)</sup><br>
 <sup>Instructies voor OsCommerce 2.2+</sup>


1. Installeer de PayPal-plug-in Express Checkout voor OsCommerce als u dat nog niet gedaan heeft. <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_plugins_oscommerce">Paypal OsCommercce Express Checkout</a>

1. Klik op de knop 'ZIP' boven aan deze pagina om de plug-in te downloaden.

2. Als u PayPal Express Checkout nog niet in uw installatie van OsCommerce heeft ingesteld, volgt u onderstaande instructies. Als PayPal Express Checkout al is ingesteld, gaat u verder met stap 3:
    + a. Log in op uw PayPal-rekening
    + b. Klik op het tabblad 'Mijn rekening' op 'Profiel'
    + c. Klik in het gedeelte 'Rekeninggegevens' op de link 'API-referenties aanvragen' of 'API-toegang'.
    + d. Klik in het volgende scherm bij Optie 2 op 'Bekijk API-handtekening' of 'API-referenties aanvragen'. U moet misschien op 'Akkoord en verzenden' klikken
    + e. Deze gegevens gebruikt u op de pagina waar u de API-referenties in OsCommerce invult. Op de pagina moet de API-gebruikersnaam, het API-wachtwoord en de API-handtekening te zien zijn.
    + f. Log in bij OsCommerce
    + g. Ga naar Modules (Modules) -> Payment (Betaling) en klik op PayPal Express checkout.
    + h. Gebruik de gegevens uit stap 2e en vul ze in door te kopiëren en plakken. 
    + i. Klik op Save (Opslaan).

3. Unzip de plug-in en pak de inhoud uit in de catalogusmap van uw webserverdirectory. mobile.php bevindt zich in de catalogusmap; de map 'mobile' is een subdirectory van de catalogusmap. Als u het zip-bestand uitpakt, wordt er een directory voor de bestanden met de naam 'PayPal-Mobile-Plugin-OsCommerce' of een soortgelijke naam gemaakt. U moet de bestanden uit deze directory naar de catalogusmap verplaatsen.

4. Maak een back-upkopie van uw huidige .htaccess-bestand in uw openbare hostingdirectory, als u die heeft.

5. Voeg het bestand mobile.htaccess samen met uw bestaande .htaccess-bestand (als u al een dergelijk bestand heeft). Dit bestand detecteert de agent voor mobiele gebruikers. 
   Opmerking: u moet "RewriteBase /catalog_folder/" toevoegen (waarbij catalog_folder het volledige bestandspad vanaf de hoofddirectory op de webserver naar uw webwinkel is) als uw installatie van OsCommerce zich niet in de hoofddirectory van de webserver bevindt.

6. Controleer vanaf uw desktopcomputer of de website nog steeds goed functioneert.

7. Controleer de website op uw telefoon en test de transactiestroom.


Instructies om de installatie ongedaan te maken
--------------------------------

1. Verwijder de wijzigingen die u in het bestand .htaccess heeft aangebracht. Of gebruik de back-upkopie van .htaccess om de wijzigingen te overschrijven. Hierdoor wordt de eerdere functionaliteit automatisch hersteld.

Ondersteunde en geteste versies
-------------------
OsCommerce: 2.3.1, 2.2 (rc1, rc2, rc2a)

### Optionele stappen


2. Verwijder het bestand mobile.php uit de hoofddirectory van uw openbare hostingdirectory.

3. Verwijder de eerder upgeloade 'mobile'-subdirectory.


<a name="espanol">Spanish</a>
-------
Instrucciones de instalación del complemento de PayPal móvil
==============================================
<sup> Con tecnología [ezimerchant](http://ezimerchant.com/)</sup><br>
 <sup>Instrucciones de OsCommerce 2.2+</sup>


1. Instale el complemento de Pago exprés de PayPal para OsCommerce si aún no lo ha hecho. <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_plugins_oscommerce">Paypal OsCommercce Express Checkout</a>

1. Haga clic en el botón 'ZIP' de la parte superior de la página para descargar el complemento.

2. Si aún no ha configurado Pago exprés de PayPal en su instalación de OsCommerce, siga estas instrucciones; si ya lo ha hecho, vaya directamente al paso 3:
    + a. Inicie sesión en su cuenta PayPal.
    + b. En la pestaña 'Mi cuenta', haga clic en 'Perfil'.
    + c. En la sección 'Información de cuenta', haga clic en el vínculo 'Solicitar credenciales de API' o 'Acceso de API'.
    + d. Bajo la opción 2 de la pantalla siguiente, haga clic en 'Ver firma de API' o 'Solicitar credenciales de API'. Es posible que deba hacer clic en 'Aceptar y enviar'.
    + e. Usará estos detalles de la página para cumplimentar las credenciales de API en OsCommerce. Debería ver un nombre de usuario de API, una contraseña de API y una firma.
    + f. Inicie sesión en OsCommerce.
    + g. Vaya a Módulos -> Pago y haga clic en Pago exprés de PayPal.
    + h. Use los datos del paso 2e. (cópielos y péguelos).
    + i. Pulse Guardar.

3. Descomprima el contenido del complemento en la carpeta catalog del directorio de su servidor web. mobile.php aparecerá en el directorio catalog y la carpeta 'mobile' será un subdirectorio dentro de este. Cuando descomprima el archivo ZIP, creará un directorio para los archivos con un nombre similar a este: "PayPal-Mobile-Plugin-OsCommerce". Deberá trasladar los archivos desde este directorio al directorio del catálogo.

4. Haga una copia de seguridad de su archivo .htaccess actual en su directorio de alojamiento público, si lo tiene.

5. Fusione el archivo mobile.htaccess con su archivo .htaccess existente (si ya tiene uno). Contiene la detección del agente de usuarios de móvil. 
   Nota: tendrá que añadir "RewriteBase /carpeta_catalog/" (donde carpeta_catalog es la ruta completa desde webroot a su tienda) si su instalación de oscommerce no se encuentra en el directorio raíz del servidor web.

6. Compruebe que el sitio sigue funcionando en su ordenador de escritorio.

7. Consulte el sitio en su teléfono y pruebe el flujo de transacciones.


Instrucciones para cancelar la instalación
--------------------------------

1. Elimine los cambios que realizó en el archivo .htacess. Alternativamente, use la copia de seguridad de .htaccess para sobrescribir los cambios. Esto debería restaurar la funcionalidad anterior.

Versiones admitidas y verificadas
-------------------
OsCommerce: 2.3.1, 2.2 (rc1,rc2,rc2a)

### Pasos opcionales


2. Elimine el archivo mobile.php de la carpeta raíz de su directorio de alojamiento público.

3. Elimine el subdirectorio móvil cargado anteriormente.



<a name="italian">Italian</a>
-------
Istruzioni per installazione plugin PayPal Mobile
==============================================
<sup> Powered by [ezimerchant](http://ezimerchant.com/)</sup><br>
 <sup>OsCommerce 2.2+ istruzioni</sup>


1. Install the <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_plugins_oscommerce">Paypal OsCommercce Express Checkout</a> plugin if you do not already have it.

1. Se non l'hai ancora fatto, installa il plugin Pagamento express OsCommerce PayPal Clicca il pulsante "ZIP" nella parte superiore della pagina per scaricare il plugin.

2. Se non hai ancora installato il Pagamento express PayPal nell'installazione OsCommerce, segui queste istruzioni. Se l'hai già installato, passa al punto 3:
    + a. Accedi al tuo conto PayPal
    + b. Nella sezione Il mio conto, clicca Profilo
    + c. Nella sezione Dati del conto, clicca il link Richiedi credenziali API o Accesso API.
    + d. All'opzione 2 della pagina successiva, clicca Vedi firma API o Richiedi credenziali API. Potrebbe essere necessario cliccare Accetta e invia
    + e. Userai i dati della pagina per completare le credenziali API in OsCommerce. Dovresti vedere il nome utente API, la password API e la firma.
    + f. Accedi a OsCommerce
    + g. Vai su Moduli-> Pagamento e clicca Pagamento express PayPal.
    + h. Usa i dati del passaggio 2e copiandoli e incollandoli.
    + i. Clicca Salva.

3. Decomprimi i contenuti del plugin e salvali nella cartella catalogo della tua directory. mobile.php si troverà nella directory del catalogo, mentre la cartella "mobile" sarà una sottodirectory all'interno della cartella catalogo. Estraendo i file zippati, verrà creata una directory per i file il cui nome sarà analogo a PayPal-Mobile-Plugin-OsCommerce. Devi spostare i file da questa directory all'interno della directory del catalogo.

4. Fai una copia di backup del file .htaccess attuale all'interno della directory di hosting pubblica, se presente.

5. Unisci il file mobile.htaccess al file .htaccess presente (se disponibile). Contiene l'identificazione dell'agente utente mobile. 
   Nota: dovrai aggiungere RewriteBase/catalog_folder/ (dove catalog_folder rappresenta il percorso completo dalla radice web al negozio) se il file di installazione di OsCommerce non si trova nella directory principale del server.

6. Controlla che il sito sia ancora in funzione sul tuo desktop.

7. Controlla il sito sul tuo telefono e testa il flusso di transazione.


Istruzioni per annullamento installazione
--------------------------------

1. Rimuovi le modifiche al file .htacess creato, oppure usa il file .htaccess di backup per sovrascrivere le modifiche. Questa operazione dovrebbe ripristinare le funzionalità precedenti.

Versioni supportate e testate
-------------------
OsCommerce: 2.3.1, 2.2 (rc1,rc2,rc2a)

### Passaggi opzionali


2. Rimuovi il file mobile.php nella radice della directory di hosting pubblica.

3. Rimuovi la sottodirectory mobile caricata in precedenza.



<a name="french">Français</a>
------

Guide d’installation du plugin PayPal Mobile
============================================

Produit par ezimerchant
----------------------
Instructions pour OsCommerce 2.3+
1. Cliquez sur le bouton ‘ZIP’ en haut de la page pour télécharger le plugin. 

2. Si vous n’avez pas encore configuré le module PayPal Express Checkout sur OsCommerce, suivez les instructions ci-dessous. Si le module est déjà configuré, passez directement à l’étape 3. 

3. + a. Connectez-vous à votre compte PayPal
  + b. Sous l’onglet “Mon compte”, cliquez sur “Préférences” 
  + c. Allez sur “Mes Ventes”. Dans la partie “Vendre en ligne”, vous verrez la ligne “Accès à l’API“. Cliquez sur “Mettre à jour “.
  + d. Un nouvel écran s’affichera. Cliquez sur “Demander des informations d’authentification API” en bas de l’option 2.  Il vous sera peut-être demandé de cliquer sur « Accepter et Envoyer ».
  + e. Vous aurez besoin de toutes ces données pour renseigner les informations d’identification PayPal sur OsCommerce, à savoir l’identifiant API, le mot de passe API et la signature. 
  + f. Connectez-vous à OsCommerce.
  + g. Allez sur Modules -> Paiement et cliquez sur PayPal Express checkout.
  + h. Copiez/collez les données obtenues lors de l’étape 2e.
  + i. Cliquez sur “Enregistrer”

3. Extrayez le contenu du plugin dans votre dossier ‘catalog’. mobile.php doit être à la racine du dossier ‘catalog’, qui contient le sous-répertoire ‘mobile’. Une fois le fichier extrait, un dossier nommé  "PayPal-Mobile-Plugin-OsCommerce" sera automatiquement créé. Vous devriez déplacer les fichiers de ce dossier et les mettre à la racine du dossier ‘catalog’. 
Si vous avez un fichier .htaccess dans le dossier ‘public hosting’, faites-en une sauvegarde. 

4. Fusionnez le fichier mobile.htaccess avec le fichier .htaccess (si vous en avez). Il contient la détection Mobile User Agent. 
Vérifiez que le site Web s’affiche correctement sur votre ordinateur. 

5. Faites de même sur le téléphone et testez le processus de commande

Annuler l’installation
----------------------

Annulez les modifications apportées au fichier .htaccess ou remettez le fichier .htaccess pré-sauvegardé pour annuler les modifications. Ceci devrait suffire à revenir à une configuration précédente 

Etapes optionnelles
-------------------

Supprimez le fichier mobile.php à la racine de du dossier ‘public hosting’
Supprimez le sous-répertoire ‘mobile’ qui a été créé précédemment.


<a name="english">English</a>
-------
PayPal Mobile Plugin Installation Instructions
==============================================
<sup> Powered by [ezimerchant](http://ezimerchant.com/)</sup><br>
 <sup>OsCommerce 2.2+ instructions</sup>


1. Install the <a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_plugins_oscommerce">Paypal OsCommercce Express Checkout</a> plugin if you do not already have it.

1. Click the 'ZIP' button at the top of this page to download the plugin.

2. If you haven't already setup PayPal Express Checkout inside your OsCommerce installation, please follow these instructions, if you have already done so, please skip to step 3:
    + a. Login into your PayPal account
    + b. Under the 'My Account' tab, click 'Profile'
    + c. Under the 'Account Information' section, click the 'Request API credentials' link or 'API Access' link.
    + d. Under Option 2 on the next screen, click 'View API Signature' or 'Request API credentials'. You may need to click 'Agree and Submit'
    + e. You will use these details on the page to fill out the API credentials in OsCommerce. You should see API Username, API Password and Signature.
    + f. Login to OsCommerce
    + g. Go to Modules -> Payment and click on PayPal Express checkout.
    + h. Use the details from step 2e. and copy and paste the details accross. 
    + i. Hit Save.

3. Unpack the contents of the plugin into the catalog folder of your webserver directory. mobile.php will be in the in catalog directory, while the 'mobile' folder will be a subdirectory within that catalog folder. When you extract the zip, it will create a directory for the files called something like "PayPal-Mobile-Plugin-OsCommerce". You must move the files out of this directory and into the catalog directory. 

4. Make a backup your current .htaccess file inside your public hosting directory - if you have one.

5. Merge mobile.htaccess file with your existing .htaccess file (if you already have one). This contains the mobile user agent detection.
Note: You will need to add "RewriteBase /catalog_folder/" (where catalog_folder is the full path from the webroot to your store) if your your oscommerce install is not in the webserver root directory.

6. Check the site is still functional on your desktop computer.

7. Check the site on your phone and test the transaction flow.


Revert Installation Instructions
--------------------------------

1. Remove the changes to the .htacess file that you have made. Or use the backed up .htaccess to overwrite the changes. This should restore previous functionality in itself.

Supported & Tested Versions
-------------------
OsCommerce: 2.3.1, 2.2 (rc1,rc2,rc2a)

### Optional Steps


2. Remove the mobile.php file in the root of your public hosting directory.

3. Remove the mobile subdirectory uploaded previously.