<?php

namespace Tests\Browser\pkg_Absences;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Tests\Browser\AbsencesDuskTest;

class AbsencesTest extends AbsencesDuskTest
{
    /**
     * @group pkg_Absences
     * Test case for creating a new Absence.
     */
    public function testCreateAbsence(): void
    {
        $this->browse(function (Browser $browser) {
            // Log in as admin
            $this->login_admin($browser);

            // Ensure the page contains 'Statistiques'
            $browser->assertSee('Statistiques');

            // Get the current URL and extract the establishment part
            $url = $browser->driver->getCurrentURL();
            $etablissment = $this->getEtablissmentFromUrl($url);

            // Navigate to the absence creation page
            $browser->visit("/{$etablissment}/absence")
                ->visit("/{$etablissment}/absence/create");

            // Select the first valid option for 'personnel'
            $this->selectFirstValidOption($browser, 'personnel');

            // Select the first valid option for 'motif'
            $this->selectFirstValidOption($browser, 'motif');

            // Set the dates for the absence
            $this->setDateValues($browser, '2024-06-04', '2024-06-07');

            // Submit the form
            $browser->press('Ajouter')
                ->waitForLocation("/{$etablissment}/absence")
                ->assertPathIs("/{$etablissment}/absence")
                ->assertSee('Absence a été ajouté avec succès.');
        });
    }


    public function testEditAbsence(): void
    {
        $this->browse(function (Browser $browser) {

            // Get the current URL and extract the establishment part
            $url = $browser->driver->getCurrentURL();
            $etablissment = $this->getEtablissmentFromUrl($url);

            // Navigate to the absence creation page
            $browser->visit("/{$etablissment}/absence");
            $browser->click('.btn.btn-default.btn-sm i.far.fa-eye'); //btn btn-default btn-sm
            $browser->click('.btn.btn-sm.btn-default i.fa-solid.fa-pen-to-square'); //btn btn-sm btn-default fa-solid fa-pen-to-square
            // Set the dates for the absence
            $this->setDateValues($browser, '2024-02-04', '2024-02-05');
            //Modifier
            $browser->press('Modifier')
                ->waitForLocation("/{$etablissment}/absence")
                ->assertPathIs("/{$etablissment}/absence")
                ->assertSee('Absence a été mis à jour avec succès.');

        });

    }



    public function testDeleteAbsence(): void
    {
        $this->browse(function (Browser $browser) {

            $url = $browser->driver->getCurrentURL();
            $etablissment = $this->getEtablissmentFromUrl($url);

            // Navigate to the absence creation page
            $browser->visit("/{$etablissment}/absence");
            $browser->click('.btn.btn-default.btn-sm i.far.fa-eye');
            $browser->click('.btn.btn-sm.btn-danger i.fas.fa-trash');//btn btn-sm btn-danger fas fa-trash
            $browser->assertDialogOpened('Êtes-vous sûr de vouloir supprimer ce Absence ?')->acceptDialog();
            // $browser->pause(10000);
            $browser->waitForText('Absence a été supprimé avec succès.');
        });
    }



    public function testExportAbsenceData(): void
    {
        $this->browse(function (Browser $browser) {

            $url = $browser->driver->getCurrentURL();
            $etablissment = $this->getEtablissmentFromUrl($url);

            // Navigate to the absence creation page
            $browser->visit("/{$etablissment}/absence");
            // Navigate to the export page
            $browser->assertSee("EXPORTER");

            // Click on the export button
            // $browser->clickLink('EXPORTER');
            $browser->visit("/{$etablissment}/absence/export"); //http://127.0.0.1:8000/Solicode/absence/export
            // $browser->pause(5000);

            // Wait for the download to complete
            // $downloadedFilePath = $browser->waitForDownload();

            // // Assert that the file is downloaded successfully
            // $this->assertFileExists($downloadedFilePath);

            // Optional: Add assertions or checks for the exported file
            // For example, you can check if the file download starts or if a success message appears.
        });
    }



    public function testPrintDocument(): void
    {
        $this->browse(function (Browser $browser) {
            $url = $browser->driver->getCurrentURL();
            $etablissment = $this->getEtablissmentFromUrl($url);

            // Navigate to the absence creation page
            $browser->visit("/{$etablissment}/absence");
            $browser->assertSee("IMPRIMER");

            // $browser->visit("/{$etablissment}/absence"); //http://127.0.0.1:8000/Solicode/absence/document-absenteisme
            $browser->click('.btn.btn-default.bg-purple i.fa-solid.fa-print'); //btn btn-default bg-purple btn-sm mt-0 fa-solid fa-print
            $this->setDateValues($browser, '2023-01-01', '2024-12-01');
            $browser->click('#select-all');
            $browser->press("Imprimer");
            $browser->pause(10000);

        });
    }





    /**
     * Extract the establishment part from the URL.
     *
     * @param string $url
     * @return string
     */
    protected function getEtablissmentFromUrl(string $url): string
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
        $segments = explode('/', trim($path, '/'));

        return $segments[0];
    }

    /**
     * Select the first valid option from a dropdown.
     *
     * @param Browser $browser
     * @param string $selectName
     * @return void
     */
    protected function selectFirstValidOption(Browser $browser, string $selectName): void
    {
        $browser->script("
            var selectElement = document.querySelector('select[name={$selectName}]');
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].value !== '') {
                    selectElement.selectedIndex = i;
                    break;
                }
            }
        ");
    }

    /**
     * Set the date values for the form.
     *
     * @param Browser $browser
     * @param string $dateDebut
     * @param string $dateFin
     * @return void
     */
    protected function setDateValues(Browser $browser, string $dateDebut, string $dateFin): void
    {
        $browser->script("
            document.querySelector('input[name=date_debut]').value = '{$dateDebut}';
            document.querySelector('input[name=date_fin]').value = '{$dateFin}';
        ");
    }

    // public function select_etablissment($browser): void
    // {
    //     $url = $browser->driver->getCurrentURL();
    //     $etablissment = $this->getEtablissmentFromUrl($url);
    //     $browser->assertPathIs("/{$etablissment}/app");

    // }

    /**
     * Extract the establishment part from the URL.
     *
     * @param string $url
     * @return string
     */
    // protected function getEtablissmentFromUrl(string $url): string
    // {
    //     $parsedUrl = parse_url($url);
    //     $path = $parsedUrl['path']; // Get the path part of the URL
    //     $segments = explode('/', trim($path, '/')); // Split the path into segments

    //     return $segments[0]; // Assuming "solicode" is always the first segment
    // }
}
