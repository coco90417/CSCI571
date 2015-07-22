drop database if exists hw4;
create database hw4;
use hw4;

drop table if exists Users;
create table Users (
    userid int(11) not null auto_increment,
    username varchar(80) not null,
    password varchar(80) not null,
    usertype varchar(80) not null,
    firstname varchar(80) not null,
    lastname varchar(80) not null,
    age int(3) not null,
    salary int(7) not null,
    primary key (userid)
);

drop table if exists Product;
create table Product (
    productid int(11) not null auto_increment,
    productcategoryid int(11) not null,
    productname varchar(80) not null,
    productdescription varchar(2000) not null,
    productprice int(11),
    primary key (productid)
);

drop table if exists ProductCategory;
create table ProductCategory (
    productcategoryid int(11) not null auto_increment,
    productcategoryname varchar(80) not null,
    productcategorydescription varchar(2000),
    primary key (productcategoryid)
);

drop table if exists SpecialSales;
create table SpecialSales (
    specialsalesid int(11) not null auto_increment,
    productid int(11) not null,
    startdate date,
    enddate date,
    percentoff int(2) not null,
    primary key (specialsalesid)
);


drop table if exists Customers;
create table Customers (
    customerid int(11) not null auto_increment,
    username  varchar(2000) not null,
    password varchar(80) not null,
    firstname varchar(80) not null,
    lastname varchar(80) not null,
    billaddress varchar(2000) ,
    shipaddress varchar(2000) ,
    creditcard BIGINT(19) ,
    security int(10),
    expirationdate date,
    primary key (customerid)
);

drop table if exists Orders;
create table Orders (
    orderid int(11) not null auto_increment,
    orderdate date,
    ordertotal BIGINT(20),
    customerid BIGINT(20),
    paid varchar(10),
    primary key (orderid)
);

drop table if exists OrderItems;
create table OrderItems (
    orderitemsid int(11) not null auto_increment,
    orderid BIGINT(19),
    count BIGINT(19),
    productid BIGINT(19),
    primary key (orderitemsid)
);


# populate
# Users
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("admin", "3374", "admin", "coco", "dong", "25", "1000000");
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("manager", "1111", "manager", "yunfei", "guo", "26", "100000");
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("sales", "2222", "sales", "hui", "yang", 26, "100000");

# ProductCategory
insert into ProductCategory (productcategoryname, productcateogrydescription)
values ("DNA Sequencing", "Sequence your whole cancer genome");
insert into ProductCategory (productcategoryname, productcateogrydescription)
values ("RNA Sequencing", "Sequence your whole cancer transcriptome");
insert into ProductCategory (productcategoryname, productcateogrydescription)
values ("ChIP Sequencing", "Profile transcription factor binding sites in your whole genome");
insert into ProductCategory (productcategoryname, productcateogrydescription)
values ("Targeted Sequencing", "Sequence the targeted genes in your cancer genome");

# Product
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("1", "DNA X10 coverage", "Human Whole Cancer Genome Sequencing via the Illumina HiSeq at X10 coverage for one person", "1400");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("1", "DNA X30 coverage", "Human Whole Cancer Genome Sequencing via the Illumina HiSeq at X30 coverage for one person", "1800");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("1", "DNA X60 coverage", "Human Whole Cancer Genome Sequencing via the Illumina HiSeq at X60 coverage for one person", "3040");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("1", "DNA X90 coverage", "Human Whole Cancer Genome Sequencing via the Illumina HiSeq at X90 coverage for one person", "4280");


insert into Product (productcategoryid, productname, productdescription, productprice)
values ("2", "RNA X10 coverage", "Human Whole Cancer Transcriptome Sequencing via the Illumina HiSeq at X10 coverage for one person", "2400");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("2", "RNA X30 coverage", "Human Whole Cancer Transcriptome Sequencing via the Illumina HiSeq at X30 coverage for one person", "2800");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("2", "RNA X60 coverage", "Human Whole Cancer Transcriptome Sequencing via the Illumina HiSeq at X60 coverage for one person", "4040");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("2", "RNA X90 coverage", "Human Whole Cancer Transcriptome Sequencing via the Illumina HiSeq at X90 coverage for one person", "5280");

insert into Product (productcategoryid, productname, productdescription, productprice)
values ("3", "ChIP-Seq X10 coverage", "Human Whole Cancer Genome CTCF binding site Sequencing via the Illumina HiSeq at X10 coverage for one person", "3400");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("3", "ChIP-Seq X30 coverage", "Human Whole Cancer Genome CTCF binding site Sequencing via the Illumina HiSeq at X30 coverage for one person", "4800");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("3", "ChIP-Seq X60 coverage", "Human Whole Cancer Genome CTCF binding site Sequencing via the Illumina HiSeq at X60 coverage for one person", "5040");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("3", "ChIP-Seq X90 coverage", "Human Whole Cancer Genome CTCF binding site Sequencing via the Illumina HiSeq at X90 coverage for one person", "6280");


insert into Product (productcategoryid, productname, productdescription, productprice)
values ("4", "100 genes", "Human Cancer gene Sequencing of top 100 cancer candidate genes via the Illumina HiSeq at X50 coverage for one person", "400");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("4", "200 genes", "Human Cancer gene Sequencing of top 200 cancer candidate genes via the Illumina HiSeq at X50 coverage for one person", "600");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("4", "300 genes", "Human Cancer gene Sequencing of top 300 cancer candidate genes via the Illumina HiSeq at X50 coverage for one person", "800");
insert into Product (productcategoryid, productname, productdescription, productprice)
values ("4", "400 genes", "Human Cancer gene Sequencing of top 400 cancer candidate genes via the Illumina HiSeq at X50 coverage for one person", "1000");

#SpecialSales
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("1", "2015-2-10", "2016-01-10", "50");
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("5", "2015-2-10", "2016-01-10", "50");
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("10", "2015-2-10", "2016-01-10", "50");
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("15", "2015-12-10", "2016-01-10", "50");

#Customers
insert into Customers ( username, password, firstname, lastname, billaddress, shipaddress, creditcard, security, expirationdate )
values ("coco90417@gmail.com", "3333", "juan", "liu", "1111 testing st,los angeles,ca,90033", "1111 testing st,los angeles,ca,90033", "2222222222222222", "222", "2015-12-12");

#Orders
insert into Orders (orderdate, ordertotal, customerid, paid)
values ("2015-07-01", "3800", "1", "yes");

insert into Orders (orderdate, ordertotal, customerid, paid)
values ("2015-07-02", "3800", "1", "yes");

insert into Orders (orderdate, ordertotal, customerid, paid)
values ("2015-07-03", "1000", "1", "yes");

#OrderItems;
insert into OrderItems(orderid, count, productid)
values ("1", "1", "1");

insert into OrderItems(orderid, count, productid)
values ("1", "1", "5");


insert into OrderItems(orderid, count, productid)
values ("2", "1", "1");

insert into OrderItems(orderid, count, productid)
values ("2", "1", "5");

insert into OrderItems(orderid, count, productid)
values ("3", "1", "16");


