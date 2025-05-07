## Po stronie frontendu (Vue 3+):

### Stwórz formularz składający się z 3 oddzielnych kroków:

1. Dane podstawowe:

   - Imię - pole tekstowe
   - Nazwisko - pole tekstowe
   - Data urodzenia - data w formacie YYYY-MM-DD, data < dziś

2. Dane kontaktowe

   - Telefon - pole tekstowe - walidacja poprawnego numeru telefonu
   - E-mail - pole tekstowe - walidacja poprawnego adresu e-mail

3. Doświadczenie zawodowe: (Tabelka z możliwością dodawania wielu pozycji)

   - Firma - pole tekstowe
   - Stanowisko - pole tekstowe
   - Data od - data w formacie YYYY-MM-DD - walidacja aby data od nie była późniejsza niż data do
   - Data do - data w formacie YYYY-MM-DD - walidacja aby data do nie była wcześniejsza niż data od

4. Zrób walidację formularza (wszystkie pola wymagane, adres email musi być poprawny)
5. Pomiędzy krokami powinna być możliwość swodobnego przechodzenia.
6. Wyślij dane na backend
7. Jeżeli zapis wykonał się poprawnie, wyświetl przesłane dane

## Po stronie backendu (Symfony 6+):

1. Stwórz model (encję), przechowujący dane wysłane z formularza (3 oddzielne encje)
2. Przyjmij dane z frontu
3. Zrób ponowną walidację pól zgodnie z zasadami wyżej
4. Jeżeli dane są poprawne zapisz je do bazy

Możesz korzystać z zewnętrznych bibliotek w Vue oraz Symfony - wskaż je jeżeli jakichś użyłeś. Struktura kodu oraz rozplanowanie komponentów, klas pod kątem ponownego użycia w aplikacji wpłynie pozytywnie na ocenę zadania.

Odpowiedzi prosimy przesłać w formie plików lub linku do repozytorium do dnia 2025-04-21. Jeżeli chcesz zrezygnować z udziału w procesie rekrutacji - proszę o taką informację.
