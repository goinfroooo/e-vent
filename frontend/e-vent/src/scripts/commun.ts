import { getCookie} from "./token";
import Config from "./config";
import {Popover} from "bootstrap";

export const formatPrice = (priceInCentimes: number) => {
    // Convertir le prix en euros
    const priceInEuros = priceInCentimes / 100;
    // Formater le prix en xxx.xx €
    return priceInEuros.toFixed(2) + ' €';
  }
  

export const get_article_data = async (token: string) => {
  try {
    //const articleId = this.$route.params.id;
    
    const route = "/article";
    let options: RequestInit = {
        method: 'POST',
        headers: {
            "X-CSRF-TOKEN": getCookie("X-CSRF-TOKEN"),
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
          "article_token": token,
        }),
    }

    
        const response = await fetch(Config.backendConfig.apiUrl + route, options);
        if (!response.ok) {
            throw new Error('La requête a échoué.');
        }
        const data = await response.json();
        return data.content;
    } catch (error) {
        console.error("Erreur lors de l'envoi du formulaire:", error);
        alert("erreur : veuillez contacter l'administrateur du site")
    }

}

export const get_cart = async () => {

    
  try {
      const user_token = getCookie("USER-TOKEN");

  if (!user_token) {
      alert ("veuillez vous connectez ou creer un compte");
      return -1;
  }
  
  const route = "/cart/get";
  let options: RequestInit = {
      method: 'POST',
      headers: {
          "X-CSRF-TOKEN": getCookie("X-CSRF-TOKEN"),
          "Content-Type": "application/json",
      },
      body: JSON.stringify({
          "user_token": user_token,
      }),
  }
  //console.log(options);

  
      const response = await fetch(Config.backendConfig.apiUrl + route, options);
      if (!response.ok) {
          throw new Error('La requête a échoué.');
      }
      const data = await response.json();
      //console.log(data);
      return data.content;
  } catch (error) {
      console.error("Erreur lors de l'envoi du formulaire:", error);
      alert("erreur : veuillez contacter l'administrateur du site")
  }

}

export const showPopover = (event :Event) => {
    if (event.target instanceof Element) {
        const pop = new Popover(event.target, { placement: 'right', trigger: 'manual', content: "L'article a bien été ajouté au panier"});
        pop.show();
        setTimeout(() => {
            pop.hide();
        }, 2000);
    }
};

export const phone_prefix = {
  "AD": "+376",
  "AF": "+93",
  "AG": "+1-268",
  "AI": "+1-264",
  "AL": "+355",
  "AM": "+374",
  "AN": "+599",
  "AO": "+244",
  "AQ": "+672",
  "AR": "+54",
  "AS": "+1-684",
  "AT": "+43",
  "AU": "+61",
  "AW": "+297",
  "AZ": "+994",
  "BA": "+387",
  "BB": "+1-246",
  "BD": "+880",
  "BE": "+32",
  "BF": "+226",
  "BG": "+359",
  "BH": "+973",
  "BI": "+257",
  "BJ": "+229",
  "BM": "+1-441",
  "BN": "+673",
  "BO": "+591",
  "BR": "+55",
  "BS": "+1-242",
  "BT": "+975",
  "BW": "+267",
  "BY": "+375",
  "BZ": "+501",
  "CA": "+1",
  "CC": "+61",
  "CD": "+243",
  "CF": "+236",
  "CI": "+225",
  "CK": "+682",
  "CL": "+56",
  "CM": "+237",
  "CN": "+86",
  "CO": "+57",
  "CR": "+506",
  "CU": "+53",
  "CV": "+238",
  "CW": "+599",
  "CX": "+61",
  "CY": "+357",
  "CZ": "+420",
  "DE": "+49",
  "DJ": "+253",
  "DK": "+45",
  "DM": "+1-767",
  "DO": "+1-809, +1-829, +1-849",
  "DZ": "+213",
  "EC": "+593",
  "EE": "+372",
  "EG": "+20",
  "ER": "+291",
  "ET": "+251",
  "FI": "+358",
  "FJ": "+679",
  "FK": "+500",
  "FM": "+691",
  "FO": "+298",
  "FR": "+33",
  "GA": "+241",
  "GD": "+1-473",
  "GE": "+995",
  "GG": "+44-1481",
  "GH": "+233",
  "GI": "+350",
  "GL": "+299",
  "GM": "+220",
  "GN": "+224",
  "GQ": "+240",
  "GR": "+30",
  "GT": "+502",
  "GU": "+1-671",
  "GW": "+245",
  "GY": "+592",
  "HK": "+852",
  "HN": "+504",
  "HR": "+385",
  "HT": "+509",
  "HU": "+36",
  "ID": "+62",
  "IE": "+353",
  "IL": "+972",
  "IM": "+44-1624",
  "IN": "+91",
  "IO": "+246",
  "IQ": "+964",
  "IR": "+98",
  "IS": "+354",
  "IT": "+39",
  "JE": "+44-1534",
  "JM": "+1-876",
  "JO": "+962",
  "JP": "+81",
  "KE": "+254",
  "KG": "+996",
  "KH": "+855",
  "KI": "+686",
  "KM": "+269",
  "KP": "+850",
  "KW": "+965",
  "KY": "+1-345",
  "KZ": "+7",
  "LA": "+856",
  "LB": "+961",
  "LI": "+423",
  "LR": "+231",
  "LS": "+266",
  "LT": "+370",
  "LU": "+352",
  "LV": "+371",
  "LY": "+218",
  "MA": "+212",
  "MC": "+377",
  "MD": "+373",
  "ME": "+382",
  "MG": "+261",
  "MH": "+692",
  "MK": "+389",
  "ML": "+223",
  "MM": "+95",
  "MN": "+976",
  "MO": "+853",
  "MP": "+1-670",
  "MR": "+222",
  "MS": "+1-664",
  "MT": "+356",
  "MU": "+230",
  "MV": "+960",
  "MW": "+265",
  "MX": "+52",
  "MY": "+60",
  "MZ": "+258",
  "NA": "+264",
  "NC": "+687",
  "NE": "+227",
  "NG": "+234",
  "NI": "+505",
  "NL": "+31",
  "NO": "+47",
  "NP": "+977",
  "NR": "+674",
  "NU": "+683",
  "NZ": "+64",
  "OM": "+968",
  "PA": "+507",
  "PE": "+51",
  "PF": "+689",
  "PG": "+675",
  "PH": "+63",
  "PK": "+92",
  "PN": "+64",
  "PS": "+970",
  "PW": "+680",
  "PY": "+595",
  "SV": "+503",
  "TD": "+235",
  "TL": "+670",
  "VG": "+1-284",
  "XK": "+383",
  "YT": "+262"
}

