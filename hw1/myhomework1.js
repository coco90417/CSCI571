var currentPatient;
makeVisible();

function patient(name, birth, telephone, email, gender, insurance, ethnicity, nationality, diagnosis, status, knowsubtype, subtype, knowgrade, grade, genome, mutation, treatment, future, consent) {
    this.name = name;
    this.birth = birth;
    this.telephone = telephone;
    this.email = email;
    this.gender = gender;
    this.insurance = insurance;
    this.ethnicity = ethnicity;
    this.nationality = nationality;
    this.diagnosis = diagnosis;
    this.status = status;
    this.knowsubtype = knowsubtype;
    this.subtype = subtype;
    this.knowgrade = knowgrade;
    this.grade = grade;
    this.genome = genome;
    this.mutation = mutation;
    this.treatment = treatment;
    this.future = future;
    this.consent = consent;
}

function valName() {
    var firstName = document.getElementById("first").value;
    var lastName = document.getElementById("last").value;
    var pattern = /^[a-z|A-Z]+$/;
    if(pattern.test(firstName) && pattern.test(lastName)){
        return true;
    }else{
        alert("Please enter valid names!");
        return false;
    }
}

function valBirth() {
    var month = document.getElementById("birth-month").value;
    var day = document.getElementById("birth-day").value;
    var year = document.getElementById("birth-year").value;
    var pattern = /^[0-9]+$/;
    if(pattern.test(month) && pattern.test(day) && pattern.test(year)){
        if(month > 12 || month < 1 || day < 1 || day > 31 || year > 2015 || year < 1900){
            alert("Please enter valid birth dates!");
            return false;
        } else{
            return true;
        }
    }else{
        alert("Please enter valid birth dates!");
        return false;
    }
}


function valTel() {
    var first = document.getElementById("tel-1").value;
    var second = document.getElementById("tel-2").value;
    var third = document.getElementById("tel-3").value;
    var patternOne = /^[0-9][0-9][0-9]$/;
    var patternTwo = /^[0-9][0-9][0-9][0-9]$/;
    if(patternOne.test(first) && patternOne.test(second) && patternTwo.test(third)){
        return true;
    }else{
        alert("Please enter valid telephone number!");
        return false;
    }
}

function valEmail() {
    var email = document.getElementById("email").value;
    var pattern = /@/;
    if(pattern.test(email)){
        return true;
    }else{
        alert("Please enter valid email!");
        return false;
    }
}


function valGender() {
    var checked = false;
    var radio = document.getElementsByName("gender");
    for ( var index = 0; index < radio.length; ++index) {
        if (radio[index].checked) {
            checked = true;
        }
    }
    if (checked == false) {
        alert("Please select your gender!");
        return false;
    }else{
        return true;
        
    }
}

function valInsurance() {
    var checked = false;
    var radio = document.getElementsByName("insurance");
    for ( var index = 0; index < radio.length; ++index) {
        if (radio[index].checked) {
            checked = true;
    }
    }
    if (checked == false) {
        return false;
    }else{
        return true;
    }
}

function getValue(radio){
    var selected = "";
    for ( var index = 0; index < radio.length; ++index) {
        if (radio[index].checked) {
            selected = radio[index].value;
        }
    }
    return selected;
}


function valEthicity() {
    var ethnicity = document.getElementById("ethnicity").options;
    var selected;
    for ( var index = 0; index < ethnicity.length; ++index) {
        if (ethnicity[index].selected) {
            selected = ethnicity[index].value;
        }
    }
    if (selected == "---") {
        return false;
    }else{
        return true;
    }
}

function valNationality() {
    var nationality = document.getElementById("nationality").options;
    var selected;
    for ( var index = 0; index < nationality.length; ++index) {
        if (nationality[index].selected) {
            selected = nationality[index].value;
        }
    }
    if (selected == "---") {
        return false;
    }else{
        return true;
    }
}

function getValues(element){
    var item = element;
    var selected = [];
    for ( var index = 0; index < item.length; ++index) {
        if (item[index].selected) {
            selected = item[index].value;
        }
    }
    return selected;
}

function finishFirst() {
    var insurance = "";
    var ethnicity = "";
    var nationality = "";
    if(valName()==true && valBirth()==true && valTel()==true  && valEmail()==true && valGender()==true){
        if(valInsurance()){
            insurance = getValue(document.getElementsByName("insurance"));
        }
        if(valEthicity()){
            ethnicity = getValues(document.getElementById("ethnithity"));
        }
        if(valNationality()){
            nationality =  getValues(document.getElementById("nationality"));
        }
        currentPatient = new patient(document.getElementById("first").value + " " + document.getElementById("last").value,
                                     document.getElementById("birth-month").value + "/" + document.getElementById("birth-day").value + "/" +
                                     document.getElementById("birth-year").value,
                                    document.getElementById("tel-1").value + "-" + document.getElementById("tel-2").value + "-" + document.getElementById("tel-3").value,
                                    document.getElementById("email").value,
                                    getValue(document.getElementsByName("gender")),
                                    insurance,
                                    ethnicity,
                                    nationality, "", "", "", "", "", "", [], "", [], [], []);
        document.getElementById("patient_info").style.visibility = "hidden";
        document.getElementById("medical_info").style.visibility = "visible";
    }
}



function valDiagnosis() {
    var month = document.getElementById("diagnosis-month").value;
    var year = document.getElementById("diagnosis-year").value;
    var pattern = /^[0-9]+$/;
    if(pattern.test(month) && pattern.test(year)){
        if(month > 12 || month < 1 || year > 2015 || year < 1900){
            alert("Please enter valid diagnosis dates!");
            return false;
        } else{
            return true;
        }
    }else{
        alert("Please enter valid diagnosis dates!");
        return false;
    }
}

function valGenome() {
    var checked = false;
    var radio = document.getElementsByName("genome");
    for ( var index = 0; index < radio.length; ++index) {
        if (radio[index].checked) {
            checked = true;
        }
    }
    if (checked == false) {
        alert("Please select valid genomic analysis that you have done!");
        return false;
    }else{
        return true;
    }
}

function getChecklist(element) {
    var value  = [];
    var checked = false;
    var checklist = element;
    for ( var index = 0; index < checklist.length; ++index) {
        if (checklist[index].checked) {
            value.push(checklist[index].value);
            checked = true;
        }
    }
    return(value);
}


function valRadio(element) {
    var checked = false;
    var radio = element;
    for ( var index = 0; index < radio.length; ++index) {
        if (radio[index].checked) {
            checked = true;
        }
    }
    if (checked == false) {
        return false;
    }else{
        return true;
    }
}

function getSelect(element) {
    var selectedvalue = "";
    if( element.options != null) {
        for ( var index = 0; index < element.options.length; ++index) {
            if (element.options[index].selected) {
                selectedvalue = element.options[index].value;
            }
        }
    };
    return selectedvalue;
}

function valMutation(){
    var mutation = document.getElementById("mutation").value;
    if(mutation){
        return true;
    }else{
        alert("Please enter genomic variant information!");
        return false;
    }
}

function finishSecond() {
    var status = "";
    var knowsubtype = "";
    var subtype = "";
    var knowgrade = "";
    var grade = "";
    var mutation = "";
    var treatment = [];
    var future = [];
    var consent = [];
    if(valDiagnosis()==true && valMutation() && valGenome()==true){
        if(valRadio(document.getElementsByName("status"))){
            status = getValue(document.getElementsByName("status"))
        }
        knowsubtype = getValue(document.getElementsByName("knowsubtype"));
        subtype = getValue(document.getElementById("subtype"));
        knowgrade = getValue(document.getElementsByName("knowgrade"));
        grade = getSelect(document.getElementById("grade"));
        mutation = document.getElementById("mutation").value;
        treatment = getChecklist(document.getElementsByName("treatment"));
        future = getChecklist(document.getElementsByName("future"));
        consent = getChecklist(document.getElementsByName("consent"));
        
        currentPatient.diagnosis = document.getElementById("diagnosis-month").value + "/" +  document.getElementById("diagnosis-year").value;
        currentPatient.status = status;
        currentPatient.knowsubtype = knowsubtype;
        currentPatient.subtype = subtype;
        currentPatient.knowgrade = knowgrade;
        currentPatient.grade = grade;
        currentPatient.genome = getChecklist(document.getElementsByName("genome"));
        currentPatient.mutation = mutation;
        currentPatient.treatment = treatment;
        currentPatient.future = future;
        currentPatient.consent = consent;
        document.getElementById("medical_info").style.visibility = "hidden";
        document.getElementById("subtype-list").style.visibility = "hidden";
        document.getElementById("grade-list").style.visibility = "hidden";
        document.getElementById("report_1").style.visibility = "visible";
        
        document.getElementById("report-insurance").innerHTML = "NA" ;
        document.getElementById("report-ethnicity").innerHTML = "NA" ;
        document.getElementById("report-nationality").innerHTML = "NA" ;
        
        
        document.getElementById("report-fullname").innerHTML = currentPatient.name ;
        document.getElementById("report-birth").innerHTML = currentPatient.birth ;
        document.getElementById("report-telephone").innerHTML = currentPatient.telephone ;
        document.getElementById("report-email").innerHTML = currentPatient.email ;
        document.getElementById("report-gender").innerHTML = currentPatient.gender ;
        if(currentPatient.insurance != ""){
            document.getElementById("report-insurance").innerHTML = currentPatient.insurance ;
        }
        if(currentPatient.ethnicity != ""){
            document.getElementById("report-ethnicity").innerHTML = currentPatient.ethnicity ;
        }
        if(currentPatient.nationality){
            document.getElementById("report-nationality").innerHTML = currentPatient.nationality ;
        }
        
    }
}



function backOne(){
    document.getElementById("patient_info").style.visibility = "visible";
    document.getElementById("medical_info").style.visibility = "hidden";
    document.getElementById("subtype-list").style.visibility = "hidden";
    document.getElementById("grade-list").style.visibility = "hidden";
}

function makeVisible() {
    if(document.getElementById("subtype-form") != null){
        document.getElementById("subtype-form").addEventListener("change", function() {
                                                        if ( document.getElementById("rb10").checked){
                                                                document.getElementById("subtype-list").style.visibility = "visible";
                                                         }else{
                                                                 document.getElementById("subtype-list").style.visibility = "hidden";
                                                                 }
                                                        });
    };
    if(document.getElementById("grade-form") != null){
    document.getElementById("grade-form").addEventListener("change", function() {
                                                       if ( document.getElementById("rb13").checked){
                                                            document.getElementById("grade-list").style.visibility = "visible";
                                                           }else{
                                                            document.getElementById("grade-list").style.visibility = "hidden";
                                                           }
                                                       });
    }
}

function toReport2(){
    document.getElementById("report_1").style.visibility = "hidden";
    document.getElementById("report_2").style.visibility = "visible";
    
  
    document.getElementById("report-status").innerHTML = "NA" ;
    document.getElementById("report-knowsubtype").innerHTML = "NA" ;
    document.getElementById("report-subtype").innerHTML = "NA" ;
    document.getElementById("report-knowgrade").innerHTML = "NA" ;
    document.getElementById("report-grade").innerHTML = "NA" ;
    
    
    document.getElementById("report-treatment").innerHTML = "NA" ;
    document.getElementById("report-update").innerHTML = "NA" ;
    document.getElementById("report-consent").innerHTML = "NA" ;
    
    
    document.getElementById("report-dianostic").innerHTML = currentPatient.diagnosis ;
    if(currentPatient.status != ""){
        document.getElementById("report-status").innerHTML = currentPatient.status ;
    }
    if(currentPatient.knowsubtype != ""){
        document.getElementById("report-knowsubtype").innerHTML = currentPatient.knowsubtype ;
    }
    if(currentPatient.subtype != ""){
        document.getElementById("report-subtype").innerHTML = currentPatient.subtype ;
    }
    if(currentPatient.knowgrade != ""){
        document.getElementById("report-knowgrade").innerHTML = currentPatient.knowgrade ;
    }
    if(currentPatient.grade != ""){
        document.getElementById("report-grade").innerHTML = currentPatient.grade ;
    }
    if(currentPatient.treatment.join() != ""){
       document.getElementById("report-treatment").innerHTML = currentPatient.treatment.join() ;
    }
    if(currentPatient.future.join()  != ""){
        document.getElementById("report-update").innerHTML = currentPatient.future.join() ;
    }
    if(currentPatient.consent.join()   != ""){
        document.getElementById("report-consent").innerHTML = currentPatient.consent.join() ;
    }
        
    document.getElementById("report-genome").innerHTML = currentPatient.genome.join() ;
    document.getElementById("report-mutation").innerHTML = currentPatient.mutation ;
}


function startAll(){
    resetTwo();
    resetOne();
    modify();
}

function resetTwo(){
    document.getElementById("second-form").reset();
     document.getElementById("subtype-form").reset();
     document.getElementById("grade-form").reset();
    document.getElementById("subtype-list").style.visibility = "hidden";
    document.getElementById("grade-list").style.visibility = "hidden";
     document.getElementById("genome-form").reset();
     document.getElementById("treatment-form").reset();
    document.getElementById("future-form").reset();
    document.getElementById("consent-form").reset();
}

function resetOne(){
    document.getElementById("first-form").reset();
    document.getElementById("insurance-form").reset();
}

function modify(){
    document.getElementById("report_2").style.visibility = "hidden";
    document.getElementById("patient_info").style.visibility = "visible";
}


function backForm(){
    document.getElementById("report_2").style.visibility = "hidden";
    document.getElementById("report_1").style.visibility = "visible";
}

