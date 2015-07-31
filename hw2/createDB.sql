drop database if exists hw2;
create database hw2;
use hw2;

drop table if exists Users;
create table Users (
    userid int(11) not null auto_increment,
    username varchar(30) not null,
    password varchar(30) not null,
    usertype varchar(30) not null,
    firstname varchar(30) not null,
    lastname varchar(30) not null,
    age int(3) not null,
    salary int(7) not null,
    primary key (userid)
);

drop table if exists Product;
create table Product (
    productid int(11) not null auto_increment,
    productcategoryid int(11) not null,
    productname varchar(30) not null,
    productdescription varchar(2000) not null,
    productprice int(11),
    primary key (productid)
);

drop table if exists ProductCategory;
create table ProductCategory (
    productcategoryid int(11) not null auto_increment,
    productcategoryname varchar(30) not null,
    productdescription varchar(2000),
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


# populate
# Users
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("admin", "3374", "admin", "coco", "dong", "25", "1000000");
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("manager", "1111", "manager", "yunfei", "guo", "26", "100000");
insert into Users (username, password, usertype, firstname, lastname, age, salary)
values ("sales", "2222", "sales", "hui", "yang", 26, "100000");

# ProductCategory
insert into ProductCategory (productcategoryname, productdescription)
values ("DNA Sequencing", "Sequence your whole cancer genome");
insert into ProductCategory (productcategoryname, productdescription)
values ("RNA Sequencing", "Sequence your whole cancer transcriptome");
insert into ProductCategory (productcategoryname, productdescription)
values ("ChIP Sequencing", "Profile transcription factor binding sites in your whole genome");
insert into ProductCategory (productcategoryname, productdescription)
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
values ("13", "2015-12-10", "2016-01-10", "50");
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("14", "2015-12-10", "2016-01-10", "50");
insert into SpecialSales (productid, startdate, enddate, percentoff)
values ("15", "2015-12-10", "2016-01-10", "50");




