function erstelleInhaltsverzeichnis(zielId) {
    const zielElement = document.getElementById(zielId);
    if (!zielElement) {
      console.error(`Ziel-Element mit ID "${zielId}" nicht gefunden.`);
      return;
    }
  
    const ueberschriften = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
    if (ueberschriften.length === 0) {
      console.warn('Keine Überschriften (h1 bis h6) auf der Seite gefunden.');
      return;
    }
  
    const inhaltsverzeichnisListe = document.createElement('ul');
    let letzteEbene = 0;
    let aktuelleListe = inhaltsverzeichnisListe;
    const listenStack = [aktuelleListe];
  
    ueberschriften.forEach((ueberschrift) => {
      const ebene = parseInt(ueberschrift.tagName.substring(1)); // h1 -> 1, h2 -> 2, usw.
      const id = ueberschrift.id || 'ueberschrift-' + Math.random().toString(36).substring(2, 15);
      ueberschrift.id = id; // Sicherstellen, dass jede Überschrift eine ID hat
  
      const listenEintrag = document.createElement('li');
      const link = document.createElement('a');
      link.href = '#' + id;
      link.textContent = ueberschrift.textContent;
      listenEintrag.appendChild(link);
  
      while (ebene > letzteEbene) {
        const neueListe = document.createElement('ul');
        aktuelleListe.appendChild(neueListe);
        listenStack.push(neueListe);
        aktuelleListe = neueListe;
        letzteEbene++;
      }
  
      while (ebene < letzteEbene) {
        listenStack.pop();
        aktuelleListe = listenStack[listenStack.length - 1];
        letzteEbene--;
      }
  
      aktuelleListe.appendChild(listenEintrag);
      letzteEbene = ebene;
    });
  
    zielElement.appendChild(inhaltsverzeichnisListe);
  }
  
  // Aufruf der Funktion, sobald das DOM vollständig geladen ist
  document.addEventListener('DOMContentLoaded', () => {
    erstelleInhaltsverzeichnis('inhaltsverzeichnis'); // Ersetze 'inhaltsverzeichnis' durch die ID des Elements, in dem das Inhaltsverzeichnis platziert werden soll
  });

//   Quelle: https://g.co/gemini/share/28ee811e0a56