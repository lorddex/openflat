function validateUser(strEmail){
  validRegExp = /^[a-zA-Z0-9]{1,}$/;
  
   // search email text for regular exp matches
    if (strEmail.search(validRegExp) == -1) {
      return false;
    } 

    return true; 
}
