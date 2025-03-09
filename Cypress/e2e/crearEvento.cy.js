describe("template spec", () => {

  Cypress.on('uncaught:exception', (err, runnable) => {

    console.error(err);

    return false;
  });

  it("login de empresa para crear evento", () => {
    cy.visit("http://localhost");
    cy.viewport(1380, 720);
    cy.get("#register").should("be.visible").click();
    cy.url().should("include", "/register");
    cy.get('#selectEntidad').select('Empresa');
    cy.get("#imagen").selectFile("cypress/fixtures/foto.jpg", { force: true });
    cy.get("#nameEmpresa").type('CompanyDevelopers', { force: true });
    cy.get('#cif').should('be.visible').type('B12345678'); 
    cy.get('#direccion').type('Calle Mexico');
    cy.get('#telefono').type('623456789');
    cy.get('#emailEmpresa').type('companydevelopers@gmail.com',{force: true});
    cy.get('#cuentaBancaria').type('ES8000755174538626917678');
    cy.get("#passwordEmpresa").type('contraseñasegura1234', { force: true });
    cy.get('#registerEmpresa').click(); 
    cy.get('#imagenPerfil', { timeout: 10000 }).should('be.visible').click();
    cy.contains('Crear Eventos').click();
    cy.get('input[type="file"]').selectFile('cypress/fixtures/foto.jpg', { force: true });
    cy.get('#nombre').type('EVENTAZO');
    cy.get('#fecha').type('2025-11-11');
    cy.get('#hora').type('14:15');
    cy.get('#autocomplete').type('Canada');
    cy.get('#descripcion').type('No te pierdas este gran eventazo!');
    cy.get('#ciudad').type('Canada');
    cy.get('#precio').type('100€');
    cy.get('#stock').type('100');
    cy.get('#crearEvento').click();
    cy.get('#buscador').type('EVENTAZO');
    cy.get('#buscadorEventos').click();
  });
});
