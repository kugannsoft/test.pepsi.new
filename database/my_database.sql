-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2025 at 07:38 AM
-- Server version: 10.11.10-MariaDB-cll-lve
-- PHP Version: 8.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nsoftsoft_test_pepsi`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPM_SAVE_ACCOUNT` (IN `P_AccNo` VARCHAR(20), IN `P_AccDate` DATETIME, IN `P_CusCode` INT(10), IN `P_AccType` INT(10), IN `P_ItemCategory` INT(10), IN `P_CusNic` INT(11), IN `P_Location` VARCHAR(30), IN `P_Remark` INT(100), IN `P_InvUser` INT(10), IN `P_AccId` INT(10))  NO SQL BEGIN

















INSERT INTO `account_details`








(`AccNo`,`AccDate`,`CusCode`,`AccType`,`ItemCategory`,`CusNic`,`Location`,`Remark`,`InvUser`,`IsCreate`,`AccId`)








VALUES








(P_AccNo,P_AccDate,P_CusCode,P_AccType,P_ItemCategory,P_CusNic,P_Location,P_Remark,P_InvUser,0,P_AccId);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPM_SAVE_ACC_GUARANTEE` (IN `P_AccNo` VARCHAR(20), IN `P_GuranteeNic` VARCHAR(11), IN `P_GuranteeCode` VARCHAR(10), IN `P_GuranteeNo` TINYINT(2))   BEGIN

















INSERT INTO `acc_gurantee`








(`AccNo`,`GuranteeNic`,`GuranteeNo`,`GuranteeCode`)








VALUES








(P_AccNo,P_GuranteeNic,P_GuranteeNo,P_GuranteeCode);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPP_UPDATE_PRICE_STOCK` (IN `ProCode` VARCHAR(10), IN `InvQty` DECIMAL(20,2), IN `InvPriceLevel` TINYINT(3), IN `InvUnitCost` DECIMAL(20,2), IN `InvUnitPrice` DECIMAL(20,2), IN `InvLocation` TINYINT(2), IN `InvSerialNo` VARCHAR(50), IN `InvFreeQty` DECIMAL(20,2), IN `InvReturnQty` DECIMAL(20,2), IN `IsReturn` TINYINT(1))  NO SQL BEGIN



DECLARE PRD_QTY DECIMAL(18,2);

DECLARE PRICE_QTY DECIMAL(18,2);



SELECT  IFNULL(Stock,0) INTO @PRD_QTY FROM productstock WHERE Location =InvLocation AND ProductCode = ProCode;

SELECT  IFNULL(Stock,0) INTO @PRICE_QTY FROM pricestock WHERE PSCode = ProCode AND PSLocation = InvLocation AND PSPriceLevel = InvPriceLevel AND Price = InvUnitPrice;



IF NOT EXISTS (SELECT ProductCode FROM productstock  WHERE Location = InvLocation AND ProductCode = ProCode) THEN



INSERT INTO productstock  (ProductCode, Location , Stock , OpenStock )

VALUES (ProCode,InvLocation,(0 -(InvQty+InvFreeQty)),0);



ELSE



UPDATE productstock SET Stock = ( IFNULL(@PRD_QTY,0) -  IFNULL((InvQty+InvFreeQty),0))

WHERE ProductCode = ProCode AND Location = InvLocation;



END IF;



IF NOT EXISTS (SELECT  PSCode  FROM  pricestock  WHERE PSCode = ProCode AND PSLocation = InvLocation AND PSPriceLevel = InvPriceLevel AND Price = InvUnitPrice) THEN



INSERT INTO  pricestock ( PSCode , PSLocation , PSPriceLevel , Price , Stock , UnitCost )

     VALUES (ProCode ,InvLocation,InvPriceLevel,InvUnitPrice,(0 - (InvQty+InvFreeQty)),InvUnitCost);

ELSE



UPDATE pricestock

SET Stock = ( IFNULL(@PRICE_QTY,0) - IFNULL((InvQty+InvFreeQty),0))

WHERE PSCode = ProCode AND PSLocation = InvLocation AND PSPriceLevel = InvPriceLevel AND Price = InvUnitPrice;

END IF;





IF (InvSerialNo <> '') THEN

UPDATE productserialstock

SET Quantity = 0

WHERE ProductCode = ProCode AND Location = InvLocation AND SerialNo = InvSerialNo;

END IF;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_CASH_BALANCE_SHEET` (IN `P_BalDate` DATE, IN `P_Loc` TINYINT, IN `P_User` VARCHAR(20))   BEGIN

DECLARE BalDate Date;

SET @BalDate=P_BalDate;



CREATE TEMPORARY TABLE IF NOT EXISTS tbalance(

	BALANCE_ID VARCHAR(15),

	BALANCE_DATE DATETIME,

	CASHIER VARCHAR(15),

	START_TIME DATETIME,

	START_FLOT DECIMAL(18,2),

	END_TIME DATETIME,

	END_FLOT DECIMAL(18,2),

	NET_AMOUNT DECIMAL(18,2),

	CASH_SALES DECIMAL(18,2),

	CREDIT_SALES DECIMAL(18,2),

CHEQUE_SALES DECIMAL(18,2),

BANK_SALES DECIMAL(18,2),

	CARD_SALES DECIMAL(18,2),

	DISCOUNT DECIMAL(18,2),

	CASH_IN DECIMAL(18,2),

	CASH_OUT DECIMAL(18,2),

	BALANCE_AMOUNT DECIMAL(18,2),

	RETURN_AMOUNT DECIMAL(18,2),

	CUSTOMER_PAYMENT DECIMAL(18,2),

	SUPPLIER_PAYMENT DECIMAL(18,2),

	ADVANCE_PAYMENT DECIMAL(18,2)

);



TRUNCATE TABLE tbalance ; 

INSERT INTO tbalance (BALANCE_ID,BALANCE_DATE,CASHIER,START_TIME,START_FLOT,END_TIME,END_FLOT,NET_AMOUNT,CASH_SALES

                ,CREDIT_SALES,CARD_SALES,CHEQUE_SALES, BANK_SALES, DISCOUNT,CASH_IN,CASH_OUT,BALANCE_AMOUNT,RETURN_AMOUNT,CUSTOMER_PAYMENT,SUPPLIER_PAYMENT)

SELECT ID, DATE(BalanceDate),SystemUser, (StartTime), StartFlot, (EndTime), EndFlot,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM   cashierbalancesheet

WHERE  Location = P_Loc AND DATE(BalanceDate) = P_BalDate AND SystemUser = P_User;



UPDATE tbalance

SET NET_AMOUNT = ((SELECT IFNULL(SUM(JobNetAmount), 0) FROM jobinvoicehed WHERE JobLocation=P_Loc AND DATE(JobInvoiceDate) = P_BalDate AND (JobInvoiceDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND IsCancel = 0))

+((SELECT IFNULL(SUM(InvNetAmount), 0) FROM invoicehed WHERE InvLocation=P_Loc AND DATE(InvDate) = P_BalDate AND (InvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND InvIsCancel = 0 AND InvHold=0))

+(SELECT IFNULL(SUM(SalesNetAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND InvIsCancel = 0);



UPDATE tbalance

SET CASH_SALES = (SELECT IFNULL(SUM(SalesCashAmount),0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND InvIsCancel = 0)

+(SELECT IFNULL(SUM(JobCashAmount+ThirdCashAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Cash'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate AND (jobinvoicepaydtl.JobInvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCashAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Cash'  AND DATE(invoicepaydtl.InvDate) = P_BalDate AND (invoicepaydtl.InvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET CREDIT_SALES = ((SELECT IFNULL(SUM(SalesCreditAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobCreditAmount+ThirdCreditAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Credit'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate AND (jobinvoicepaydtl.JobInvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCreditAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Credit'  AND DATE(invoicepaydtl.InvDate) = P_BalDate AND (invoicepaydtl.InvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET CARD_SALES = ((SELECT IFNULL(SUM(SalesCCardAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobCardAmount+ThirdCardAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Card'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate AND (jobinvoicepaydtl.JobInvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCCardAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Card'  AND DATE(invoicepaydtl.InvDate) = P_BalDate AND (invoicepaydtl.InvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET CHEQUE_SALES = ((SELECT IFNULL(SUM(SalesChequeAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobChequeAmount+ThirdChequeAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Cheque'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate AND (jobinvoicepaydtl.JobInvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND IsCancel = 0);



UPDATE tbalance

SET BANK_SALES = ((SELECT IFNULL(SUM(SalesBankAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobBankAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Bank'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate AND (jobinvoicepaydtl.JobInvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND IsCancel = 0);





UPDATE tbalance

SET DISCOUNT = ((SELECT IFNULL(SUM(SalesDisAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND (SalesDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobTotalDiscount),0) FROM jobinvoicehed WHERE JobLocation=P_Loc AND DATE(JobInvoiceDate) = P_BalDate AND (JobInvoiceDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME)  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvDisAmount),0) FROM invoicehed WHERE InvLocation=P_Loc AND  DATE(invoicehed.InvDate) = P_BalDate AND (invoicehed.InvDate) BETWEEN (tbalance.START_TIME) AND (tbalance.END_TIME) AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET ADVANCE_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND  AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0 AND (PayDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME );



UPDATE tbalance

SET CASH_OUT = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE Location=P_Loc AND AppNo = 1 AND DATE(InOutDate) = P_BalDate AND (InOutDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME AND Mode = 'Out' AND IsActive = 1  );



UPDATE tbalance

SET CASH_IN = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE Location=P_Loc AND  AppNo = 1 AND DATE(InOutDate) = P_BalDate AND (InOutDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME AND Mode = 'In' AND IsActive = 1 );



UPDATE tbalance

SET RETURN_AMOUNT = (SELECT IFNULL(SUM(ReturnAmount),0) FROM returninvoicehed WHERE ReturnLocation=P_Loc AND  AppNo = 1 AND DATE(ReturnDate) = P_BalDate AND (ReturnDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME AND IsCancel = 0);



UPDATE tbalance

SET CUSTOMER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND PaymentType=1 AND AppNo = 1 AND  DATE(PayDate) = P_BalDate AND  (PayDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME  AND IsCancel = 0);



UPDATE tbalance

SET SUPPLIER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM supplierpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  DATE(PayDate) = P_BalDate AND  (PayDate) BETWEEN tbalance.START_TIME AND tbalance.END_TIME AND IsCancel = 0);



UPDATE tbalance

SET BALANCE_AMOUNT = (((IFNULL(CUSTOMER_PAYMENT,0) +  IFNULL(ADVANCE_PAYMENT,0)+  IFNULL(CASH_SALES,0) + IFNULL(START_FLOT,0) + IFNULL(CASH_IN,0) - IFNULL(CASH_OUT,0)  - IFNULL(SUPPLIER_PAYMENT,0))) - IFNULL(RETURN_AMOUNT,0));



SELECT * FROM tbalance;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_DAILY_BALANCE_SHEET` (IN `P_BalDate` DATE, IN `P_Loc` TINYINT, IN `P_User` VARCHAR(20))  NO SQL BEGIN

DECLARE BalDate Date;

SET @BalDate=P_BalDate;



CREATE TEMPORARY TABLE IF NOT EXISTS tbalance(

	BALANCE_ID VARCHAR(15),

	BALANCE_DATE DATETIME,

	CASHIER VARCHAR(15),

	START_TIME DATETIME,

	START_FLOT DECIMAL(18,2),

	END_TIME DATETIME,

	END_FLOT DECIMAL(18,2),

	NET_AMOUNT DECIMAL(18,2),

	CASH_SALES DECIMAL(18,2),

	CREDIT_SALES DECIMAL(18,2),

	CARD_SALES DECIMAL(18,2),

	CHEQUE_SALES DECIMAL(18,2),

	BANK_SALES DECIMAL(18,2),

	DISCOUNT DECIMAL(18,2),

	CASH_IN DECIMAL(18,2),

	CASH_OUT DECIMAL(18,2),

	EX_IN DECIMAL(18,2),

	EX_OUT DECIMAL(18,2),

	BALANCE_AMOUNT DECIMAL(18,2),

	RETURN_AMOUNT DECIMAL(18,2),

	CUSTOMER_PAYMENT DECIMAL(18,2),

	SUPPLIER_PAYMENT DECIMAL(18,2),

	ADVANCE_PAYMENT DECIMAL(18,2),

	SALARY DECIMAL(18,2)

);



TRUNCATE TABLE tbalance ; 

INSERT INTO tbalance (BALANCE_ID,BALANCE_DATE,CASHIER,START_TIME,START_FLOT,END_TIME,END_FLOT,NET_AMOUNT,CASH_SALES

                ,CREDIT_SALES,CARD_SALES,CHEQUE_SALES,BANK_SALES,DISCOUNT,CASH_IN,CASH_OUT,BALANCE_AMOUNT,RETURN_AMOUNT,CUSTOMER_PAYMENT,SALARY,EX_IN,EX_OUT)

VALUES ('', P_BalDate,P_User, NOW(), 0, NOW(), 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);



UPDATE tbalance

SET NET_AMOUNT = ((SELECT IFNULL(SUM(JobNetAmount), 0) FROM jobinvoicehed WHERE JobLocation=P_Loc AND DATE(JobInvoiceDate) = P_BalDate   AND IsCancel = 0))

+((SELECT IFNULL(SUM(InvNetAmount), 0) FROM invoicehed WHERE InvLocation=P_Loc AND DATE(InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold=0))

+(SELECT IFNULL(SUM(SalesNetAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate  AND InvIsCancel = 0);



UPDATE tbalance

SET CASH_SALES = (SELECT IFNULL(SUM(JobCashAmount+ThirdCashAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Cash'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate   AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCashAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Cash'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0)

+(SELECT IFNULL(SUM(SalesCashAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);



UPDATE tbalance

SET CHEQUE_SALES = (SELECT IFNULL(SUM(JobChequeAmount+ThirdChequeAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Cheque'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate   AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvChequeAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Cheque'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(ChequePay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0)

+(SELECT IFNULL(SUM(ChequePay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0)

+(SELECT IFNULL(SUM(SalesChequeAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);



UPDATE tbalance

SET BANK_SALES = ((SELECT IFNULL(SUM(SalesBankAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND AppNo = 1 AND DATE(SalesDate) = P_BalDate AND SalesInvHold = 0 AND InvIsCancel = 0))

+(SELECT IFNULL(SUM(JobBankAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Bank'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(SalesBankAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);





UPDATE tbalance

SET CREDIT_SALES = (SELECT IFNULL(SUM(JobCreditAmount+ThirdCreditAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Credit'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCreditAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Credit'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(SalesCreditAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);



UPDATE tbalance

SET CARD_SALES = (SELECT IFNULL(SUM(JobCardAmount+ThirdCardAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE JobLocation=P_Loc AND jobinvoicepaydtl.JobInvPayType='Card'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCCardAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE InvLocation=P_Loc AND invoicepaydtl.InvPayType='Card'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(CardPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0)

+(SELECT IFNULL(SUM(CardPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0)

+(SELECT IFNULL(SUM(SalesCCardAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);

UPDATE tbalance

SET DISCOUNT = (SELECT IFNULL(SUM(JobTotalDiscount),0) FROM jobinvoicehed WHERE JobLocation=P_Loc AND DATE(JobInvoiceDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvDisAmount),0) FROM invoicehed WHERE  InvLocation=P_Loc AND DATE(invoicehed.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(SalesDisAmount), 0) FROM salesinvoicehed WHERE SalesLocation=P_Loc AND DATE(SalesDate) = P_BalDate AND InvIsCancel = 0);



UPDATE tbalance

SET ADVANCE_PAYMENT = (SELECT IFNULL(SUM(TotalPayment),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0);



UPDATE tbalance

SET CASH_OUT = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE Location=P_Loc AND AppNo = 1 AND DATE(InOutDate) = P_BalDate AND TransCode!='12' AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET SALARY = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE Location=P_Loc AND AppNo = 1 AND DATE(InOutDate) = P_BalDate AND TransCode='12'   AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET CASH_IN = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE Location=P_Loc AND AppNo = 1 AND DATE(InOutDate) = P_BalDate AND Mode = 'In' AND IsActive = 1 );



UPDATE tbalance

SET RETURN_AMOUNT = (SELECT IFNULL(SUM(ReturnAmount),0) FROM returninvoicehed WHERE ReturnLocation=P_Loc AND AppNo = 1 AND DATE(ReturnDate) = P_BalDate  AND IsCancel = 0);



UPDATE tbalance

SET CUSTOMER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0);



UPDATE tbalance

SET SUPPLIER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM supplierpaymenthed WHERE Location=P_Loc AND AppNo = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0);



UPDATE tbalance

SET EX_OUT = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE Location=P_Loc AND  AppNo = 1 AND DATE(FlotDate) = P_BalDate AND IsExpenses = 1 );



UPDATE tbalance

SET EX_IN = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE Location=P_Loc AND AppNo = 1 AND DATE(FlotDate) = P_BalDate AND IsExpenses = 0 );





UPDATE tbalance

SET BALANCE_AMOUNT = ((IFNULL(CUSTOMER_PAYMENT,0) - IFNULL(SUPPLIER_PAYMENT,0)+  IFNULL(CASH_SALES,0) + IFNULL(START_FLOT,0) + IFNULL(CASH_IN,0) - IFNULL(CASH_OUT,0)- IFNULL(SALARY,0)+ IFNULL(EX_IN,0) - IFNULL(EX_OUT,0)) - IFNULL(RETURN_AMOUNT,0));



SELECT * FROM tbalance;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_DAILY_CASH_BALANCE_SHEET` (IN `P_BalDate` DATE, IN `P_Loc` TINYINT, IN `P_User` VARCHAR(20))  NO SQL BEGIN

DECLARE BalDate Date;

SET @BalDate=P_BalDate;



CREATE TEMPORARY TABLE IF NOT EXISTS tbalance(

	BALANCE_ID VARCHAR(15),

	BALANCE_DATE DATETIME,

	CASHIER VARCHAR(15),

	START_TIME DATETIME,

	START_FLOT DECIMAL(18,2),

	END_TIME DATETIME,

	END_FLOT DECIMAL(18,2),

	NET_AMOUNT DECIMAL(18,2),

	CASH_SALES DECIMAL(18,2),

	CREDIT_SALES DECIMAL(18,2),

	CARD_SALES DECIMAL(18,2),

	DISCOUNT DECIMAL(18,2),

	CASH_IN DECIMAL(18,2),

	CASH_OUT DECIMAL(18,2),

	EX_IN DECIMAL(18,2),

	EX_OUT DECIMAL(18,2),

	BALANCE_AMOUNT DECIMAL(18,2),

	RETURN_AMOUNT DECIMAL(18,2),

	CUSTOMER_PAYMENT DECIMAL(18,2),

	SUPPLIER_PAYMENT DECIMAL(18,2),

	ADVANCE_PAYMENT DECIMAL(18,2),

	SALARY DECIMAL(18,2)

);



TRUNCATE TABLE tbalance ; 

INSERT INTO tbalance (BALANCE_ID,BALANCE_DATE,CASHIER,START_TIME,START_FLOT,END_TIME,END_FLOT,NET_AMOUNT,CASH_SALES

                ,CREDIT_SALES,CARD_SALES,DISCOUNT,CASH_IN,CASH_OUT,BALANCE_AMOUNT,RETURN_AMOUNT,CUSTOMER_PAYMENT,SALARY,EX_IN,EX_OUT)

SELECT ID, DATE(BalanceDate),SystemUser, (StartTime), StartFlot, (EndTime), EndFlot,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM   cashierbalancesheet

WHERE  Location = P_Loc AND DATE(BalanceDate) = P_BalDate;



UPDATE tbalance

SET NET_AMOUNT = ((SELECT IFNULL(SUM(JobNetAmount), 0) FROM jobinvoicehed WHERE DATE(JobInvoiceDate) = P_BalDate   AND IsCancel = 0))

+((SELECT IFNULL(SUM(InvNetAmount), 0) FROM invoicehed WHERE DATE(InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold=0));



UPDATE tbalance

SET CASH_SALES = (SELECT IFNULL(SUM(JobCashAmount+ThirdCashAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Cash'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate   AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCashAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Cash'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0);





UPDATE tbalance

SET CREDIT_SALES = (SELECT IFNULL(SUM(JobCreditAmount+ThirdCreditAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Credit'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCreditAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Credit'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET CARD_SALES = (SELECT IFNULL(SUM(JobCardAmount+ThirdCardAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Card'  AND DATE(jobinvoicepaydtl.JobInvDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCCardAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Card'  AND DATE(invoicepaydtl.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET DISCOUNT = (SELECT IFNULL(SUM(JobTotalDiscount),0) FROM jobinvoicehed WHERE DATE(JobInvoiceDate) = P_BalDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvDisAmount),0) FROM invoicehed WHERE  DATE(invoicehed.InvDate) = P_BalDate  AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET ADVANCE_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) = P_BalDate AND  IsCancel = 0);



UPDATE tbalance

SET CASH_OUT = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) = P_BalDate AND TransCode!='12' AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET SALARY = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) = P_BalDate AND TransCode='12'   AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET CASH_IN = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) = P_BalDate AND Mode = 'In' AND IsActive = 1 );



UPDATE tbalance

SET RETURN_AMOUNT = (SELECT IFNULL(SUM(ReturnAmount),0) FROM returninvoicehed WHERE AppNo = 1 AND DATE(ReturnDate) = P_BalDate  AND IsCancel = 0);



UPDATE tbalance

SET CUSTOMER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0);



UPDATE tbalance

SET SUPPLIER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM supplierpaymenthed WHERE AppNo = 1 AND  DATE(PayDate) = P_BalDate  AND  IsCancel = 0);



UPDATE tbalance

SET EX_OUT = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE AppNo = 1 AND DATE(FlotDate) = P_BalDate AND IsExpenses = 1 );



UPDATE tbalance

SET EX_IN = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE AppNo = 1 AND DATE(FlotDate) = P_BalDate AND IsExpenses = 0 );





UPDATE tbalance

SET BALANCE_AMOUNT = ((IFNULL(CUSTOMER_PAYMENT,0) - IFNULL(SUPPLIER_PAYMENT,0)+ IFNULL(ADVANCE_PAYMENT,0)+  IFNULL(CASH_SALES,0) + IFNULL(START_FLOT,0) + IFNULL(CASH_IN,0) - IFNULL(CASH_OUT,0)- IFNULL(SALARY,0)+ IFNULL(EX_IN,0) - IFNULL(EX_OUT,0)) - IFNULL(RETURN_AMOUNT,0));



SELECT * FROM tbalance;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_MONTHLY_BALANCE_SHEET` (IN `P_BalDate` DATE, IN `P_EndDate` DATE, IN `P_Loc` TINYINT, IN `P_User` VARCHAR(20))  NO SQL BEGIN

DECLARE BalDate Date;

SET @BalDate=P_BalDate;



CREATE TEMPORARY TABLE IF NOT EXISTS tbalance(

	BALANCE_ID VARCHAR(15),

	BALANCE_DATE DATETIME,

	END_DATE DATETIME,

	CASHIER VARCHAR(15),

	START_TIME DATETIME,

	START_FLOT DECIMAL(18,2),

	END_TIME DATETIME,

	END_FLOT DECIMAL(18,2),

	NET_AMOUNT DECIMAL(18,2),

	CASH_SALES DECIMAL(18,2),

	CREDIT_SALES DECIMAL(18,2),

	CARD_SALES DECIMAL(18,2),

	CHEQUE_SALES DECIMAL(18,2),

	DISCOUNT DECIMAL(18,2),

	CASH_IN DECIMAL(18,2),

	CASH_OUT DECIMAL(18,2),

	EX_IN DECIMAL(18,2),

	EX_OUT DECIMAL(18,2),

	BALANCE_AMOUNT DECIMAL(18,2),

	RETURN_AMOUNT DECIMAL(18,2),

	CUSTOMER_PAYMENT DECIMAL(18,2),

	SUPPLIER_PAYMENT DECIMAL(18,2),

	ADVANCE_PAYMENT DECIMAL(18,2),

	SALARY DECIMAL(18,2)

);



TRUNCATE TABLE tbalance ; 

INSERT INTO tbalance (BALANCE_ID,BALANCE_DATE,END_DATE,CASHIER,START_TIME,START_FLOT,END_TIME,END_FLOT,NET_AMOUNT,CASH_SALES

                ,CREDIT_SALES,CARD_SALES,CHEQUE_SALES,DISCOUNT,CASH_IN,CASH_OUT,BALANCE_AMOUNT,RETURN_AMOUNT,CUSTOMER_PAYMENT,SALARY,EX_IN,EX_OUT)

VALUES ('', P_BalDate,P_EndDate,P_User, '', 0, '', 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);



UPDATE tbalance

SET NET_AMOUNT = ((SELECT IFNULL(SUM(JobNetAmount), 0) FROM jobinvoicehed WHERE DATE(JobInvoiceDate) BETWEEN P_BalDate  AND P_EndDate AND IsCancel = 0))

+((SELECT IFNULL(SUM(InvNetAmount), 0) FROM invoicehed WHERE DATE(InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold=0));



UPDATE tbalance

SET CASH_SALES = (SELECT IFNULL(SUM(JobCashAmount+ThirdCashAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Cash'  AND DATE(jobinvoicepaydtl.JobInvDate) BETWEEN P_BalDate  AND P_EndDate   AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCashAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Cash'  AND DATE(invoicepaydtl.InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate AND  IsCancel = 0);



UPDATE tbalance

SET CHEQUE_SALES = (SELECT IFNULL(SUM(JobChequeAmount+ThirdChequeAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Cheque'  AND DATE(jobinvoicepaydtl.JobInvDate) BETWEEN P_BalDate  AND P_EndDate   AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvChequeAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Cheque'  AND DATE(invoicepaydtl.InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(ChequePay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate AND  IsCancel = 0)

+(SELECT IFNULL(SUM(ChequePay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate AND  IsCancel = 0);





UPDATE tbalance

SET CREDIT_SALES = (SELECT IFNULL(SUM(JobCreditAmount+ThirdCreditAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Credit'  AND DATE(jobinvoicepaydtl.JobInvDate) BETWEEN P_BalDate  AND P_EndDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCreditAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Credit'  AND DATE(invoicepaydtl.InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET CARD_SALES = (SELECT IFNULL(SUM(JobCardAmount+ThirdCardAmount),0) FROM jobinvoicehed INNER JOIN jobinvoicepaydtl ON jobinvoicepaydtl.JobInvNo=jobinvoicehed.JobInvNo WHERE jobinvoicepaydtl.JobInvPayType='Card'  AND DATE(jobinvoicepaydtl.JobInvDate) BETWEEN P_BalDate  AND P_EndDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvCCardAmount),0) FROM invoicehed INNER JOIN invoicepaydtl ON invoicepaydtl.InvNo=invoicehed.InvNo WHERE invoicepaydtl.InvPayType='Card'  AND DATE(invoicepaydtl.InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold = 0)

+(SELECT IFNULL(SUM(CardPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate AND  IsCancel = 0)

+(SELECT IFNULL(SUM(CardPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate  AND  IsCancel = 0);

UPDATE tbalance

SET DISCOUNT = (SELECT IFNULL(SUM(JobTotalDiscount),0) FROM jobinvoicehed WHERE DATE(JobInvoiceDate) BETWEEN P_BalDate  AND P_EndDate  AND IsCancel = 0)

+(SELECT IFNULL(SUM(InvDisAmount),0) FROM invoicehed WHERE  DATE(invoicehed.InvDate) BETWEEN P_BalDate  AND P_EndDate  AND InvIsCancel = 0 AND InvHold = 0);



UPDATE tbalance

SET ADVANCE_PAYMENT = (SELECT IFNULL(SUM(TotalPayment),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 2 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate AND  IsCancel = 0);



UPDATE tbalance

SET CASH_OUT = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) BETWEEN P_BalDate  AND P_EndDate AND TransCode!='12' AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET SALARY = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) BETWEEN P_BalDate  AND P_EndDate AND TransCode='12'   AND Mode = 'Out' AND IsActive = 1 );



UPDATE tbalance

SET CASH_IN = (SELECT IFNULL(SUM(CashAmount),0) FROM cashinout WHERE AppNo = 1 AND DATE(InOutDate) BETWEEN P_BalDate  AND P_EndDate AND Mode = 'In' AND IsActive = 1 );



UPDATE tbalance

SET RETURN_AMOUNT = (SELECT IFNULL(SUM(ReturnAmount),0) FROM returninvoicehed WHERE AppNo = 1 AND DATE(ReturnDate) BETWEEN P_BalDate  AND P_EndDate  AND IsCancel = 0);



UPDATE tbalance

SET CUSTOMER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM customerpaymenthed WHERE AppNo = 1 AND  PaymentType = 1 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate  AND  IsCancel = 0);



UPDATE tbalance

SET SUPPLIER_PAYMENT = (SELECT IFNULL(SUM(CashPay),0) FROM supplierpaymenthed WHERE AppNo = 1 AND  DATE(PayDate) BETWEEN P_BalDate  AND P_EndDate  AND  IsCancel = 0);



UPDATE tbalance

SET EX_OUT = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE AppNo = 1 AND DATE(FlotDate) BETWEEN P_BalDate  AND P_EndDate AND IsExpenses = 1 );



UPDATE tbalance

SET EX_IN = (SELECT IFNULL(SUM(FlotAmount),0) FROM cashflot INNER JOIN transactiontypes ON transactiontypes.TransactionCode=cashflot.TransactionCode WHERE AppNo = 1 AND DATE(FlotDate) BETWEEN P_BalDate  AND P_EndDate AND IsExpenses = 0 );





UPDATE tbalance

SET BALANCE_AMOUNT = ((IFNULL(CUSTOMER_PAYMENT,0) - IFNULL(SUPPLIER_PAYMENT,0)+  IFNULL(CASH_SALES,0) + IFNULL(START_FLOT,0) + IFNULL(CASH_IN,0) - IFNULL(CASH_OUT,0)- IFNULL(SALARY,0)+ IFNULL(EX_IN,0) - IFNULL(EX_OUT,0)) - IFNULL(RETURN_AMOUNT,0));



SELECT * FROM tbalance;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_STOCK_FINAL` (`P_FDate` DATE, `P_TDate` DATE, `P_Loc` TINYINT, IN `P_Code` VARCHAR(20), IN `P_Dep` INT(3), IN `P_Subdep` INT(3))   BEGIN

DECLARE RpDate Date;

SET @RpDate=P_FDate;



CREATE TEMPORARY TABLE IF NOT EXISTS StockSummary (

    

	RDate DATE,

	ProductCode VARCHAR(20),

	ProductName VARCHAR(150),

	Category INT(3),

CategoryName VARCHAR(30),

	L1IN DECIMAL(18,2) DEFAULT 0.00,

	L2IN DECIMAL(18,2) DEFAULT 0.00,

	L3IN DECIMAL(18,2) DEFAULT 0.00,

	L4IN DECIMAL(18,2) DEFAULT 0.00,

	L5IN DECIMAL(18,2) DEFAULT 0.00,

	L1OUT DECIMAL(18,2) DEFAULT 0.00,

	L2OUT DECIMAL(18,2) DEFAULT 0.00,

	L3OUT DECIMAL(18,2) DEFAULT 0.00,

	L4OUT DECIMAL(18,2) DEFAULT 0.00,

	L5OUT DECIMAL(18,2) DEFAULT 0.00,

	SALES_QTY DECIMAL(18,2) DEFAULT 0.00,

	GRN_QTY DECIMAL(18,2) DEFAULT 0.00,

	STOCK DECIMAL(18,2) DEFAULT 0.00,

PRIMARY KEY ( RDate,ProductCode )

);

TRUNCATE TABLE StockSummary ;



IF P_FDate!=P_TDate THEN





WHILE @RpDate  <= P_TDate DO



INSERT INTO StockSummary (RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK)

SELECT @RpDate, product.ProductCode ,product.Prd_AppearName,product.SubDepCode,subdepartment.Description,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM product INNER JOIN productcondition ON productcondition.ProductCode=product.ProductCode

INNER JOIN subdepartment ON subdepartment.SubDepCode=product.SubDepCode

WHERE 	product.Prd_IsActive = 1 AND productcondition.IsSerial=1 AND

 product.ProductCode = CASE IFNULL(P_Code , 'NULL') WHEN 'NULL' THEN product.ProductCode ELSE P_Code END AND

 product.DepCode = CASE IFNULL(P_Dep , 0) WHEN 0 THEN product.DepCode ELSE P_Dep END AND

 product.SubDepCode = CASE IFNULL(P_Subdep , 0) WHEN 0 THEN product.SubDepCode ELSE P_Subdep END 

ORDER BY product.SubDepCode;





SET @RpDate=(SELECT DATE_ADD(@RpDate,INTERVAL 1 DAY));

END WHILE;



ELSE



INSERT INTO StockSummary (RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK)

SELECT @RpDate, product.ProductCode ,product.Prd_AppearName,product.SubDepCode,subdepartment.Description,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM product INNER JOIN productcondition ON productcondition.ProductCode=product.ProductCode

INNER JOIN subdepartment ON subdepartment.SubDepCode=product.SubDepCode

WHERE 	product.Prd_IsActive = 1 AND productcondition.IsSerial=1 AND

 product.ProductCode = CASE IFNULL(P_Code , 'NULL') WHEN 'NULL' THEN product.ProductCode ELSE P_Code END AND

 product.DepCode = CASE IFNULL(P_Dep , 0) WHEN 0 THEN product.DepCode ELSE P_Dep END AND

 product.SubDepCode = CASE IFNULL(P_Subdep , 0) WHEN 0 THEN product.SubDepCode ELSE P_Subdep END 

ORDER BY product.SubDepCode;





END IF;







UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 1

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L1IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 2

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L2IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 3

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L3IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 4

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L4IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 5

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L5IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;











UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 1 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L1OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 2 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L2OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 3 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L3OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 4 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L4OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 5 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L5OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.InvDate) AS InvDate, D.InvProductCode ,SUM(InvQty) AS InvQty

FROM   invoicedtl AS D INNER JOIN

       invoicehed AS H ON D.InvNo = H.InvNo

WHERE  DATE(D.InvDate) BETWEEN P_FDate AND P_TDate AND D.InvLocation = P_Loc AND H.InvHold = 0 AND H.InvIsCancel = 0

GROUP BY DATE(D.InvDate), D.InvProductCode

) T2

SET SALES_QTY = T2.InvQty

WHERE T.ProductCode = T2.InvProductCode AND DATE(T.RDate) = T2.InvDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.GRN_Date) AS GRN_Date, D.GRN_Product ,SUM(D.GRN_Qty) AS GRN_Qty

FROM   goodsreceivenotedtl AS D INNER JOIN

       goodsreceivenotehed AS H ON D.GRN_No = H.GRN_No

WHERE  DATE(D.GRN_Date) BETWEEN P_FDate AND P_TDate AND H.GRN_Location = P_Loc AND H.GRN_IsCancel = 0

GROUP BY DATE(D.GRN_Date), D.GRN_Product

) T2

SET T.GRN_QTY = T2.GRN_Qty

WHERE T.ProductCode = T2.GRN_Product AND DATE(T.RDate) = T2.GRN_Date;





UPDATE StockSummary AS T,

(

SELECT DATE(StockDate) AS StockDate , ProductCode , SUM(Stock) AS Stock

FROM stockdate 

WHERE  DATE(StockDate) BETWEEN P_FDate AND P_TDate AND Location=P_Loc

GROUP BY DATE(StockDate), ProductCode

) T2

SET T.STOCK= T2.Stock

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.StockDate;



SELECT RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK

FROM StockSummary

WHERE (L1IN + L2IN + L3IN + L4IN + L5IN + L1OUT + L2OUT + L3OUT + L4OUT + L5OUT + SALES_QTY + GRN_QTY) <> 0 OR STOCK <> 0

ORDER BY RDate,Category,ProductCode;





END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPR_STOCK_FINAL_V2` (`P_FDate` DATE, `P_TDate` DATE, `P_Loc` TINYINT, IN `P_Code` VARCHAR(20), IN `P_Dep` INT(3), IN `P_Subdep` INT(3), IN `P_Subcat` INT(3))   BEGIN

DECLARE RpDate Date;

SET @RpDate=P_FDate;



CREATE TEMPORARY TABLE IF NOT EXISTS StockSummary (

    

	RDate DATE,

	ProductCode VARCHAR(20),

	ProductName VARCHAR(150),

	Category INT(3),

CategoryName VARCHAR(30),

	L1IN DECIMAL(18,2) DEFAULT 0.00,

	L2IN DECIMAL(18,2) DEFAULT 0.00,

	L3IN DECIMAL(18,2) DEFAULT 0.00,

	L4IN DECIMAL(18,2) DEFAULT 0.00,

	L5IN DECIMAL(18,2) DEFAULT 0.00,

	L1OUT DECIMAL(18,2) DEFAULT 0.00,

	L2OUT DECIMAL(18,2) DEFAULT 0.00,

	L3OUT DECIMAL(18,2) DEFAULT 0.00,

	L4OUT DECIMAL(18,2) DEFAULT 0.00,

	L5OUT DECIMAL(18,2) DEFAULT 0.00,

	SALES_QTY DECIMAL(18,2) DEFAULT 0.00,

	GRN_QTY DECIMAL(18,2) DEFAULT 0.00,

	STOCK DECIMAL(18,2) DEFAULT 0.00,

PRIMARY KEY ( RDate,ProductCode )

);

TRUNCATE TABLE StockSummary ;



IF P_FDate!=P_TDate THEN





WHILE @RpDate  <= P_TDate DO



INSERT INTO StockSummary (RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK)

SELECT @RpDate, product.ProductCode ,product.Prd_AppearName,product.SubDepCode,subdepartment.Description,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM product INNER JOIN productcondition ON productcondition.ProductCode=product.ProductCode

INNER JOIN subdepartment ON subdepartment.SubDepCode=product.SubDepCode

WHERE 	product.Prd_IsActive = 1 AND productcondition.IsSerial=1 AND

 product.ProductCode = CASE IFNULL(P_Code , 'NULL') WHEN 'NULL' THEN product.ProductCode ELSE P_Code END AND

 product.DepCode = CASE IFNULL(P_Dep , 0) WHEN 0 THEN product.DepCode ELSE P_Dep END AND

 product.SubDepCode = CASE IFNULL(P_Subdep , 0) WHEN 0 THEN product.SubDepCode ELSE P_Subdep END  AND

product.SubCategoryCode = CASE IFNULL(P_Subcat , 0) WHEN 0 THEN product.SubCategoryCode ELSE P_Subcat END 

ORDER BY product.SubDepCode;





SET @RpDate=(SELECT DATE_ADD(@RpDate,INTERVAL 1 DAY));

END WHILE;



ELSE



INSERT INTO StockSummary (RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK)

SELECT @RpDate, product.ProductCode ,product.Prd_AppearName,product.SubDepCode,subdepartment.Description,0,0,0,0,0,0,0,0,0,0,0,0,0

FROM product INNER JOIN productcondition ON productcondition.ProductCode=product.ProductCode

INNER JOIN subdepartment ON subdepartment.SubDepCode=product.SubDepCode

WHERE 	product.Prd_IsActive = 1 AND productcondition.IsSerial=1 AND

 product.ProductCode = CASE IFNULL(P_Code , 'NULL') WHEN 'NULL' THEN product.ProductCode ELSE P_Code END AND

 product.DepCode = CASE IFNULL(P_Dep , 0) WHEN 0 THEN product.DepCode ELSE P_Dep END AND

 product.SubDepCode = CASE IFNULL(P_Subdep , 0) WHEN 0 THEN product.SubDepCode ELSE P_Subdep END  AND

product.SubCategoryCode = CASE IFNULL(P_Subcat , 0) WHEN 0 THEN product.SubCategoryCode ELSE P_Subcat END

ORDER BY product.SubDepCode;





END IF;







UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 1

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L1IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 2

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L2IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 3

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L3IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 4

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L4IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE  (H.TransIsInProcess = 0) AND DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = P_Loc AND D.FromLocation = 5

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L5IN = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;











UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 1 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L1OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 2 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L2OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 3 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L3OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 4 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L4OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.TrnsDate) AS TrnsDate, D.ProductCode ,SUM(D.TransQty) AS TransQty

FROM   stocktransferdtl AS D INNER JOIN

       stocktransferhed AS H ON D.TrnsNo = H.TrnsNo

WHERE   DATE(D.TrnsDate) BETWEEN P_FDate AND P_TDate  AND D.ToLocation = 5 AND D.FromLocation = P_Loc

GROUP BY DATE(D.TrnsDate), D.ProductCode

) T2

SET T.L5OUT = T2.TransQty

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.TrnsDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.InvDate) AS InvDate, D.InvProductCode ,SUM(InvQty) AS InvQty

FROM   invoicedtl AS D INNER JOIN

       invoicehed AS H ON D.InvNo = H.InvNo

WHERE  DATE(D.InvDate) BETWEEN P_FDate AND P_TDate AND D.InvLocation = P_Loc AND H.InvHold = 0 AND H.InvIsCancel = 0

GROUP BY DATE(D.InvDate), D.InvProductCode

) T2

SET SALES_QTY = T2.InvQty

WHERE T.ProductCode = T2.InvProductCode AND DATE(T.RDate) = T2.InvDate;





UPDATE StockSummary AS T,

(

SELECT DATE(D.GRN_Date) AS GRN_Date, D.GRN_Product ,SUM(D.GRN_Qty) AS GRN_Qty

FROM   goodsreceivenotedtl AS D INNER JOIN

       goodsreceivenotehed AS H ON D.GRN_No = H.GRN_No

WHERE  DATE(D.GRN_Date) BETWEEN P_FDate AND P_TDate AND H.GRN_Location = P_Loc AND H.GRN_IsCancel = 0

GROUP BY DATE(D.GRN_Date), D.GRN_Product

) T2

SET T.GRN_QTY = T2.GRN_Qty

WHERE T.ProductCode = T2.GRN_Product AND DATE(T.RDate) = T2.GRN_Date;





UPDATE StockSummary AS T,

(

SELECT DATE(StockDate) AS StockDate , ProductCode , SUM(Stock) AS Stock

FROM stockdate 

WHERE  DATE(StockDate) BETWEEN P_FDate AND P_TDate AND Location=P_Loc

GROUP BY DATE(StockDate), ProductCode

) T2

SET T.STOCK= T2.Stock

WHERE T.ProductCode = T2.ProductCode AND DATE(T.RDate) = T2.StockDate;



SELECT RDate,ProductCode,ProductName,Category,CategoryName,L1IN,L2IN,L3IN,L4IN,L5IN,L1OUT,L2OUT,L3OUT,L4OUT,L5OUT,SALES_QTY,GRN_QTY,STOCK

FROM StockSummary

WHERE (L1IN + L2IN + L3IN + L4IN + L5IN + L1OUT + L2OUT + L3OUT + L4OUT + L5OUT + SALES_QTY + GRN_QTY) <> 0 OR STOCK <> 0

ORDER BY RDate,Category,ProductCode;





END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_CANCEL_CUSTOMER_PAYMENT` (IN `P_CancelDate` DATETIME, IN `P_PaymentNo` VARCHAR(10), IN `P_CancelUser` VARCHAR(5), IN `P_Remark` VARCHAR(100), IN `P_CusCode` VARCHAR(10), IN `P_CancelNo` VARCHAR(10), IN `P_Location` TINYINT(1))   BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

DECLARE total_inv_amount DECIMAL(20,2);

DECLARE payment_amount DECIMAL(20,2);

DECLARE new_settle_amount DECIMAL(20,2);

DECLARE cinv_settle_amount DECIMAL(20,2);





DECLARE x INT(2);

DECLARE i INT(2);



SELECT `TotalPayment` INTO @payment_amount FROM `customerpaymenthed` WHERE `CusPayNo`=P_PaymentNo;

SELECT `CusTotalInvAmount` INTO @total_inv_amount FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

SELECT `CusSettlementAmount` INTO @cus_settle_amount FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;



SET @total_inv_amount=@total_inv_amount-@payment_amount;

SET @total_oustanding=@total_oustanding-@payment_amount;

SET @cus_settle_amount=@cus_settle_amount-@cinv_settle_amount;



IF NOT EXISTS (SELECT CusCode FROM customeroutstanding WHERE CusCode =P_CusCode) THEN

INSERT INTO customeroutstanding

(CusCode,CusTotalInvAmount,CusOustandingAmount,CusSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES (P_CusCode,(@payment_amount),(@payment_amount) ,0,0,0);



ELSE

   

UPDATE customeroutstanding 

SET CusOustandingAmount = (CusOustandingAmount + @payment_amount),CusSettlementAmount=(CusSettlementAmount- @payment_amount)

WHERE CusCode = P_CusCode;

           

END IF;



UPDATE `customerpaymenthed`

SET `IsCancel`=1,CancelUser=P_CancelUser

WHERE `CusPayNo`=P_PaymentNo AND CusCode=P_CusCode AND Location=P_Location;



UPDATE creditinvoicedetails AS C,

(

SELECT InvNo,PayAmount

FROM   invoicesettlementdetails AS S 

WHERE  CusPayNo=P_PaymentNo

) T2

SET C.SettledAmount = (C.SettledAmount-T2.PayAmount),C.IsCloseInvoice=0

WHERE C.InvoiceNo=T2.InvNo;



INSERT INTO cancelcustomerpayment

(`AppNo`,`Location`,`CancelNo`,`CancelDate`,`PaymentNo`,`CusCode`,`CancelAmount`,`CancelRemark`,`CancelUser`)

VALUES (1,P_Location,P_CancelNo,P_CancelDate,P_PaymentNo,P_CusCode,@payment_amount,P_Remark,P_CancelUser);



UPDATE chequedetails

SET IsCancel = 1

WHERE ReferenceNo = P_PaymentNo;



DELETE FROM invoicesettlementdetails WHERE CusPayNo=P_PaymentNo;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_CANCEL_GRN` (IN `P_CancelDate` DATETIME, IN `P_PaymentNo` VARCHAR(10), IN `P_CancelUser` VARCHAR(5), IN `P_Remark` VARCHAR(100), IN `P_CusCode` VARCHAR(10), IN `P_CancelNo` VARCHAR(10), IN `P_Location` TINYINT(1))   BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

DECLARE total_inv_amount DECIMAL(20,2);

DECLARE payment_amount DECIMAL(20,2);

DECLARE new_settle_amount DECIMAL(20,2);

DECLARE cinv_settle_amount DECIMAL(20,2);





DECLARE x INT(2);

DECLARE i INT(2);



SELECT `GRN_NetAmount` INTO @payment_amount FROM `goodsreceivenotehed` WHERE `GRN_No`=P_PaymentNo;

SELECT `SupTotalInvAmount` INTO @total_inv_amount FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;

SELECT `SupOustandingAmount` INTO @total_oustanding FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;

SELECT `SupSettlementAmount` INTO @cus_settle_amount FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;

SELECT `SettledAmount` INTO @cinv_settle_amount FROM `creditgrndetails` WHERE `SupCode`=P_CusCode AND GRNNo=P_PaymentNo;



SET @total_inv_amount=@total_inv_amount-@payment_amount;

SET @total_oustanding=@total_oustanding-@payment_amount;

SET @cus_settle_amount=@cus_settle_amount-@cinv_settle_amount;



UPDATE `supplieroustanding`

SET `SupTotalInvAmount`=@total_inv_amount,`SupOustandingAmount`=@total_oustanding,`SupSettlementAmount`=@cus_settle_amount

WHERE `SupCode`=P_CusCode;





UPDATE `goodsreceivenotehed`

SET `GRN_IsCancel`=1

WHERE `GRN_No`=P_PaymentNo;



UPDATE `creditgrndetails` SET `IsCancel`='1' WHERE `GRNNo`=P_PaymentNo;





INSERT INTO `cancelgrn` (`AppNo`,`CancelNo`,`Location`,`CancelDate`,`GRNNo`,`Remark`,`CancelUser`)

VALUES(1,P_CancelNo,P_Location,P_CancelDate,P_PaymentNo,P_Remark,P_CancelUser);





END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_CANCEL_INVOICE` (IN `P_CancelDate` DATETIME, IN `P_PaymentNo` VARCHAR(10), IN `P_CancelUser` VARCHAR(5), IN `P_Remark` VARCHAR(100), IN `P_CusCode` VARCHAR(10), IN `P_InvNo` VARCHAR(10))   BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

DECLARE payment_amount DECIMAL(20,2);

DECLARE cinv_settle_amount DECIMAL(20,2);

DECLARE new_settle_amount DECIMAL(20,2);

DECLARE credit_amount DECIMAL(20,2);

DECLARE total_inv_amount DECIMAL(20,2);

DECLARE cus_total_inv_amount DECIMAL(20,2);

DECLARE close_invoice INT(1);



SELECT `CusTotalInvAmount` INTO @cus_total_inv_amount FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

SELECT `CusSettlementAmount` INTO @cus_settle_amount FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;



SELECT `SettledAmount` INTO @cinv_settle_amount FROM `credit_invoice` WHERE `InvoiceNo`=P_InvNo;

SELECT `IsCloseInvoice` INTO @close_invoice FROM `credit_invoice` WHERE `InvoiceNo`=P_InvNo;



SELECT `CreditAmount` INTO @credit_amount FROM `sold_item_hed` WHERE `InvNo`=P_InvNo;

SELECT `TotalAmount` INTO @total_inv_amount FROM `sold_item_hed` WHERE `InvNo`=P_InvNo;



SET @cus_total_inv_amount=@cus_total_inv_amount-@total_inv_amount;

SET @cus_settle_amount=@cus_settle_amount-@cinv_settle_amount;

SET @total_oustanding=@total_oustanding-@credit_amount;



IF close_invoice=1 THEN

SET @close_invoice=0;

END IF;



UPDATE `customeroutstanding`

SET `CusSettlementAmount`=@total_settle_amount,`CusOustandingAmount`=@total_oustanding,`CusTotalInvAmount`=@cus_total_inv_amount

WHERE `CusCode`=P_CusCode;



UPDATE `credit_invoice`

SET IsCancel=1 WHERE `InvoiceNo` = P_InvNo;



UPDATE `sold_item_hed`

SET `IsCancel`=1

WHERE `InvNo`=P_InvNo;



INSERT INTO `cancel_invoice` (`CancelDate`,`InvoiceNo`,`Remark`,`CancelUser`)

VALUES(P_CancelDate,P_InvNo,P_Remark,P_CancelUser);



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_CANCEL_SUPPLIER_PAYMENT` (IN `P_CancelDate` DATETIME, IN `P_PaymentNo` VARCHAR(10), IN `P_CancelUser` VARCHAR(5), IN `P_Remark` VARCHAR(100), IN `P_CusCode` VARCHAR(10), IN `P_CancelNo` VARCHAR(10), IN `P_Location` TINYINT(1))   BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

DECLARE total_inv_amount DECIMAL(20,2);

DECLARE payment_amount DECIMAL(20,2);

DECLARE new_settle_amount DECIMAL(20,2);

DECLARE cinv_settle_amount DECIMAL(20,2);





DECLARE x INT(2);

DECLARE i INT(2);



SELECT `TotalPayment` INTO @payment_amount FROM `supplierpaymenthed` WHERE `SupPayNo`=P_PaymentNo;

SELECT `SupTotalInvAmount` INTO @total_inv_amount FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;

SELECT `SupOustandingAmount` INTO @total_oustanding FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;

SELECT `SupSettlementAmount` INTO @cus_settle_amount FROM `supplieroustanding` WHERE `SupCode`=P_CusCode;



SET @total_inv_amount=@total_inv_amount-@payment_amount;

SET @total_oustanding=@total_oustanding-@payment_amount;

SET @cus_settle_amount=@cus_settle_amount-@cinv_settle_amount;



IF NOT EXISTS (SELECT SupCode FROM supplieroustanding WHERE SupCode =P_CusCode) THEN

INSERT INTO supplieroustanding

(SupCode,SupTotalInvAmount,SupOustandingAmount,SupSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES (P_CusCode,(@payment_amount),(@payment_amount) ,0,0,0);



ELSE

   

UPDATE supplieroustanding 

SET SupOustandingAmount = (SupOustandingAmount + @payment_amount),SupSettlementAmount=(SupSettlementAmount- @payment_amount)

WHERE SupCode = P_CusCode;

           

END IF;



UPDATE `supplierpaymenthed`

SET `IsCancel`=1,CancelUser=P_CancelUser

WHERE `SupPayNo`=P_PaymentNo AND SupCode=P_CusCode AND Location=P_Location;



UPDATE creditgrndetails AS C,

(

SELECT GRNNo,PayAmount

FROM   grnsettlementdetails AS S 

WHERE  SupPayNo=P_PaymentNo

) T2

SET C.SettledAmount = (C.SettledAmount-T2.PayAmount),C.IsCloseGRN=0

WHERE C.GRNNo=T2.GRNNo;



INSERT INTO cancelsupplierpayment

(`AppNo`,`Location`,`CancelNo`,`CancelDate`,`PaymentNo`,`SupCode`,`CancelAmount`,`CancelRemark`,`CancelUser`)

VALUES (1,P_Location,P_CancelNo,P_CancelDate,P_PaymentNo,P_CusCode,@payment_amount,P_Remark,P_CancelUser);



UPDATE chequedetails

SET IsCancel = 1

WHERE ReferenceNo = P_PaymentNo;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_CASIHER_BALANCE` (IN `P_AppNo` TINYINT(2), IN `P_SetAmount` DECIMAL(20,2), IN `P_BalanceDate` DATETIME, IN `P_SetDateTime` DATETIME, IN `P_Mode` VARCHAR(6), IN `P_Location` TINYINT(2), IN `P_ID` VARCHAR(15), IN `P_SystemUser` TINYINT(2))  NO SQL BEGIN



IF P_Mode ='S' THEN



IF NOT EXISTS (SELECT ID FROM cashierbalancesheet WHERE AppNo = P_AppNo AND Location = P_Location AND ID = P_ID AND SystemUser = P_SystemUser) THEN



INSERT INTO cashierbalancesheet (AppNo,Location,ID,SystemUser,BalanceDate,StartTime,StartFlot,EndTime,EndFlot)

VALUES (P_AppNo,P_Location,P_ID,P_SystemUser,P_BalanceDate,P_SetDateTime,P_SetAmount,P_SetDateTime,0);



ELSE

UPDATE cashierbalancesheet

   SET StartFlot = SetAmount

 WHERE AppNo = P_AppNo AND Location = P_Location AND ID = P_ID AND SystemUser = P_SystemUser;



END IF;

END IF;





IF P_Mode ='E' THEN



IF NOT EXISTS (SELECT ID FROM cashierbalancesheet WHERE AppNo = P_AppNo AND Location = P_Location AND ID = P_ID AND SystemUser = P_SystemUser) THEN



INSERT INTO cashierbalancesheet (AppNo,Location,ID,SystemUser,BalanceDate,StartTime,StartFlot,EndTime,EndFlot)

VALUES (P_AppNo,P_Location,P_ID,P_SystemUser,P_BalanceDate,P_SetDateTime,0,P_SetDateTime,P_SetAmount);



ELSE

UPDATE cashierbalancesheet

   SET EndFlot = P_SetAmount, EndTime = P_SetDateTime

 WHERE AppNo = P_AppNo AND Location = P_Location AND ID = P_ID AND SystemUser = P_SystemUser;



END IF;

END IF;





END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_DOWN_PAID` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_PayDate` DATETIME, IN `P_InvNo` VARCHAR(20), IN `P_CusCode` VARCHAR(20), IN `P_ChequeRecDate` DATE, IN `P_ChequeDate` DATE, IN `P_ChequeReference` VARCHAR(100), IN `P_PayAmount` DECIMAL(20,2), IN `P_SettleAmount` DECIMAL(20,2), IN `P_InvoiceColse` TINYINT(1), IN `P_ChequeNo` VARCHAR(50), IN `P_CashAmount` DECIMAL(20,2), IN `P_ChequeAmount` DECIMAL(20,2), IN `P_Over_PayAmount` DECIMAL(20,2), IN `P_Over_PayInv` VARCHAR(20), IN `P_ExAmount` DECIMAL(20,2), IN `P_InsAmount` DECIMAL(20,2), IN `P_InvDate` DATETIME, IN `P_AccNo` VARCHAR(20))   BEGIN

















DECLARE cus_settle_amount DECIMAL(20,2);








DECLARE total_oustanding DECIMAL(20,2);


























SET @cus_settle_amount:=(SELECT `CusSettlementAmount` FROM `customeroutstanding` WHERE `CusCode`=P_CusCode);








SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

















SET @cus_settle_amount=@cus_settle_amount+P_PayAmount;








SET @total_oustanding=@total_oustanding-P_PayAmount;


























UPDATE `customeroutstanding`








SET `CusSettlementAmount`=@cus_settle_amount,`CusOustandingAmount`=@total_oustanding








WHERE `CusCode`=P_CusCode;

















INSERT INTO `down_paid`








(`PaymentId`,`PaymentType`,`PayDate`,`PayAmount`,`InvNo`,`AccNo`,`CusCode`,`ChequeNo`,`ChequeRecDate`,`ChequeDate`,`ChequeReference`,`TotalPayment`,`CashPayment`,`ChequePayment`,`ExtraAmount`,`InsuranceAmount`,`InvDate`)








VALUES








(P_PaymentId,P_PaymentType,P_PayDate,P_PayAmount,P_InvNo,P_AccNo,P_CusCode,P_ChequeNo,P_ChequeRecDate,P_ChequeDate,P_ChequeReference,P_PayAmount,P_CashAmount,P_ChequeAmount,P_ExAmount,P_InsAmount,P_InvDate);

















IF P_Over_PayAmount>0 THEN

















INSERT INTO `cus_over_payment_dtl`








(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`)








VALUES








(P_PaymentId,P_PaymentType,P_Over_PayAmount,P_Over_PayInv);








END IF;

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_DOWN_PAID_DTL` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_InvNo` VARCHAR(20), IN `P_PayAmount` DECIMAL(20,2), IN `P_Month` TINYINT(3), IN `P_AccNo` VARCHAR(20))  NO SQL BEGIN

















INSERT INTO `down_paid_dtl`








(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`,`AccNo`,`Month`)








VALUES








(P_PaymentId,P_PaymentType,P_PayAmount,P_InvNo,P_AccNo,P_Month);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_DWN_PAYMENT` (IN `P_InvNo` VARCHAR(20), IN `P_DwPayType` TINYINT(3), IN `P_DownPayment` DECIMAL(20,2), IN `P_Interest` DECIMAL(10,2), IN `P_InterestAmount` DECIMAL(20,2), IN `P_PaymentDate` DATE, IN `P_IsInterest` TINYINT(1))   BEGIN

















INSERT INTO `down_payment_dtl`








(`InvNo`,`DwPayType`,`DownPayment`,`Interest`,`InterestAmount`,`PaymentDate`,`IsInterest`)








VALUES








(P_InvNo,P_DwPayType,P_DownPayment,P_Interest,P_InterestAmount,P_PaymentDate,P_IsInterest);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_EXTRA_AMOUNT` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_PayDate` DATE, IN `P_PayDesc` VARCHAR(100), IN `P_ExtraAmount` DECIMAL(20,2), IN `P_PaymentDate` DATE, IN `P_ExtraNo` TINYINT(2))   BEGIN


























INSERT INTO `invoice_extra_amount`








(`InvNo`,`AccNo`,`PayDate`,`PayDesc`,`ExtraAmount`,`PaymentDate`,`ExtraNo`)








VALUES








(P_InvNo,P_AccNo,P_PayDate,P_PayDesc,P_ExtraAmount,P_PaymentDate,P_ExtraNo);

















          

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_INV_DTL` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_ItemType` TINYINT(1), IN `P_InvLocation` VARCHAR(10), IN `P_InvDate` DATETIME, IN `P_InvProductCode` VARCHAR(30), IN `P_InvSerialNo` VARCHAR(50), IN `P_LineNo` TINYINT(2), IN `P_InvQty` DECIMAL(10,2), IN `P_InvPriceLevel` TINYINT(1), IN `P_InvUnitPrice` DECIMAL(10,2), IN `P_InvCostPrice` DECIMAL(10,2), IN `P_InvDisValue` DECIMAL(10,2), IN `P_InvDisPercentage` DECIMAL(10,2), IN `P_InvTotalAmount` DECIMAL(20,2), IN `P_InvNetAmount` DECIMAL(20,2), IN `P_IsReturn` TINYINT(1))   BEGIN

















INSERT INTO `invoice_dtl`








(`InvNo`,`AccNo`,`ItemType`,`InvLocation`,`InvDate`,`InvProductCode`,`InvSerialNo`,`InvLineNo`,`InvQty`,`InvPriceLevel`,`InvUnitPrice`,`InvCostPrice`,`InvDisValue`,`InvDisPercentage`,`InvTotalAmount`,`InvNetAmount`,`IsReturn`)








VALUES








(P_InvNo,P_AccNo,P_ItemType,P_InvLocation,P_InvDate,P_InvProductCode,P_InvSerialNo,P_LineNo,P_InvQty,P_InvPriceLevel,P_InvUnitPrice,P_InvCostPrice,P_InvDisValue,P_InvDisPercentage,P_InvTotalAmount,P_InvNetAmount,P_IsReturn);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_INV_HED` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(50), IN `P_Location` VARCHAR(150), IN `P_InvDate` DATETIME, IN `P_InvType` TINYINT(2), IN `P_ItemType` TINYINT(2), IN `P_TotalAmount` DECIMAL(20,2), IN `P_DisAmount` DECIMAL(20,2), IN `P_CashPayment` DECIMAL(20,2), IN `P_DownPayment` DECIMAL(20,2), IN `P_TotalExCharges` DECIMAL(20,2), IN `P_RefundAmount` DECIMAL(20,2), IN `P_TotalExAmount` DECIMAL(20,2), IN `P_TotalDwPayment` DECIMAL(20,2), IN `P_QuarterPayment` DECIMAL(20,2), IN `P_InterestTerm` TINYINT(3), IN `P_Interest` DECIMAL(20,2), IN `P_InterestRate` DECIMAL(20,2), IN `P_GrossAmount` DECIMAL(20,2), IN `P_Installments` DECIMAL(20,2), IN `P_InstallAmount` DECIMAL(20,2), IN `P_InvUser` TINYINT(3), IN `P_IsCancel` TINYINT(1), IN `P_IsComplete` TINYINT(1), IN `P_IsReturn` TINYINT(1), IN `P_FinalAmount` DECIMAL(20,2), IN `P_DisPercentage` INT(10), IN `P_payType` INT(10), IN `P_payDate` DATETIME, IN `P_chequemount` DECIMAL(20,2), IN `P_dueAmount` DECIMAL(20,2), IN `P_seettuNo` INT(11), IN `P_overPayment` DECIMAL(20,2), IN `P_cusCode` VARCHAR(50))   BEGIN































INSERT INTO `invoice_hed`















(`InvNo`,`AccNo`,`Location`,`InvDate`,`InvType`,`ItemType`,`TotalAmount`,`DisAmount`,`CashPayment`,`DownPayment`,`TotalExCharges`,`RefundAmount`,`TotalExAmount`,`TotalDwPayment`,`QuarterPayment`,`InterestTerm`,`Interest`,`GrossAmount`,`Installments`,`InstallAmount`,`InvUser`,`IsCancel`,`IsComplete`,`IsReturn`,`InterestRate`,`FinalAmount`,`DisPercentage`,`TotalDue`,`payt_type`,`pay_date`,`chequeAmount`,`DueAmount`,`SeettuNo`,`OverPayment`,`CusCode`)















VALUES















(P_InvNo,P_AccNo,P_Location,P_InvDate,P_InvType,P_ItemType,P_TotalAmount,P_DisAmount,P_CashPayment,P_DownPayment,P_TotalExCharges,P_RefundAmount,P_TotalExAmount,P_TotalDwPayment,P_QuarterPayment,P_InterestTerm,P_Interest,P_GrossAmount,P_Installments,P_InstallAmount,P_InvUser,P_IsCancel,P_IsComplete,P_IsReturn,P_InterestRate,P_FinalAmount,P_DisPercentage,P_dueAmount,P_payType,P_payDate,P_chequemount,P_dueAmount,P_seettuNo,P_overPayment,P_cusCode);































UPDATE `account_details` SET `IsCreate`=1 WHERE `AccNo`=P_AccNo;































END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_PAYMENT_DTL` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_Month` DECIMAL(20,2), IN `P_MonPayment` DECIMAL(10,2), IN `P_Principal` DECIMAL(20,2), IN `P_Interest` DECIMAL(20,2), IN `P_ExtraAmount` DECIMAL(20,2), IN `P_Balance` DECIMAL(20,2), IN `P_PayDate` DATE)   BEGIN

















INSERT INTO `item_payment_dtl`








(`InvNo`,`AccNo`,`Month`,`MonPayment`,`Principal`,`Interest`,`ExtraAmount`,`Balance`,`PaymentDate`)








VALUES








(P_InvNo,P_AccNo,P_Month,P_MonPayment,P_Principal,P_Interest,P_ExtraAmount,P_Balance,P_PayDate);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_RENTAL_PAID` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_PayDate` DATETIME, IN `P_InvNo` VARCHAR(20), IN `P_CusCode` VARCHAR(20), IN `P_ChequeRecDate` DATE, IN `P_ChequeDate` DATE, IN `P_ChequeReference` VARCHAR(100), IN `P_PayAmount` DECIMAL(20,2), IN `P_SettleAmount` DECIMAL(20,2), IN `P_InvoiceColse` TINYINT(1), IN `P_ChequeNo` VARCHAR(50), IN `P_CashAmount` DECIMAL(20,2), IN `P_ChequeAmount` DECIMAL(20,2), IN `P_Over_PayAmount` DECIMAL(20,2), IN `P_Over_PayInv` VARCHAR(20), IN `P_ExAmount` DECIMAL(20,2), IN `P_InsAmount` DECIMAL(20,2), IN `P_InvDate` DATETIME, IN `P_AccNo` VARCHAR(20))   BEGIN

















DECLARE cus_settle_amount DECIMAL(20,2);








DECLARE total_oustanding DECIMAL(20,2);


























SET @cus_settle_amount:=(SELECT `CusSettlementAmount` FROM `customeroutstanding` WHERE `CusCode`=P_CusCode);








SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_CusCode;

















SET @cus_settle_amount=@cus_settle_amount+P_PayAmount;








SET @total_oustanding=@total_oustanding-P_PayAmount;


























UPDATE `customeroutstanding`








SET `CusSettlementAmount`=@cus_settle_amount,`CusOustandingAmount`=@total_oustanding








WHERE `CusCode`=P_CusCode;

















INSERT INTO `rental_paid`








(`PaymentId`,`PaymentType`,`PayDate`,`PayAmount`,`InvNo`,`AccNo`,`CusCode`,`ChequeNo`,`ChequeRecDate`,`ChequeDate`,`ChequeReference`,`TotalPayment`,`CashPayment`,`ChequePayment`,`ExtraAmount`,`InsuranceAmount`,`InvDate`)








VALUES








(P_PaymentId,P_PaymentType,P_PayDate,P_PayAmount,P_InvNo,P_AccNo,P_CusCode,P_ChequeNo,P_ChequeRecDate,P_ChequeDate,P_ChequeReference,P_PayAmount,P_CashAmount,P_ChequeAmount,P_ExAmount,P_InsAmount,P_InvDate);

















IF P_Over_PayAmount>0 THEN

















INSERT INTO `cus_over_payment_dtl`








(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`)








VALUES








(P_PaymentId,P_PaymentType,P_Over_PayAmount,P_Over_PayInv);








END IF;

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_RENTAL_PAID_DTL` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_InvNo` VARCHAR(20), IN `P_PayAmount` DECIMAL(20,2), IN `P_Month` TINYINT(3), IN `P_AccNo` VARCHAR(20))  NO SQL BEGIN

















INSERT INTO `rental_paid_dtl`








(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`,`AccNo`,`Month`)








VALUES








(P_PaymentId,P_PaymentType,P_PayAmount,P_InvNo,P_AccNo,P_Month);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_RENTAL_PAYMENT_DTL` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_Month` DECIMAL(20,2), IN `P_MonPayment` DECIMAL(10,2), IN `P_Principal` DECIMAL(20,2), IN `P_Interest` DECIMAL(20,2), IN `P_ExtraAmount` DECIMAL(20,2), IN `P_Balance` DECIMAL(20,2), IN `P_PaymentDate` DATE, IN `P_DueAmountWExtra` DECIMAL(20,2), IN `P_RentalDefault` DECIMAL(20,2), IN `P_WRentalDefault` DECIMAL(20,2), IN `P_TotalDue` DECIMAL(20,2), IN `P_RentalBalance` DECIMAL(20,2), IN `P_RentalRate` DECIMAL(20,2), IN `P_RentalExcuseDays` INT)   BEGIN

















INSERT INTO `rental_payment_dtl`








(`InvNo`,`AccNo`,`Month`,`MonPayment`,`Principal`,`Interest`,`ExtraAmount`,`Balance`,`PaymentDate`,`DueAmountWExtra`,`RentalDefault`,`WRentalDefault`,`TotalDue`,`RentalBalance`,`RentalRate`,`RentalExcuseDays`)








VALUES








(P_InvNo,P_AccNo,P_Month,P_MonPayment,P_Principal,P_Interest,P_ExtraAmount,P_Balance,P_PaymentDate,P_DueAmountWExtra,P_RentalDefault,P_WRentalDefault,P_TotalDue,P_RentalBalance,P_RentalRate,P_RentalExcuseDays);

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_SUP_PAYMENT2` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_PayDate` DATETIME, IN `P_InvNo` VARCHAR(20), IN `P_CusCode` VARCHAR(20), IN `P_ChequeRecDate` DATE, IN `P_ChequeDate` DATE, IN `P_ChequeReference` VARCHAR(100), IN `P_PayAmount` DECIMAL(20,2), IN `P_SettleAmount` DECIMAL(20,2), IN `P_InvoiceColse` TINYINT(1), IN `P_ChequeNo` VARCHAR(50), IN `P_CashAmount` DECIMAL(20,2), IN `P_ChequeAmount` DECIMAL(20,2), IN `P_Over_PayAmount` DECIMAL(20,2), IN `P_Over_PayInv` VARCHAR(20))   BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);





SET @cus_settle_amount:=(SELECT `CusSettlementAmount` FROM `supplieroutstanding` WHERE `CusCode`=P_CusCode);

SELECT `CusOustandingAmount` INTO @total_oustanding FROM `supplieroutstanding` WHERE `CusCode`=P_CusCode;



SET @cus_settle_amount=@cus_settle_amount+P_PayAmount;

SET @total_oustanding=@total_oustanding-P_PayAmount;





UPDATE `supplieroutstanding`

SET `CusSettlementAmount`=@cus_settle_amount,`CusOustandingAmount`=@total_oustanding

WHERE `CusCode`=P_CusCode;



INSERT INTO `supplier_payment`

(`PaymentId`,`PaymentType`,`PayDate`,`PayAmount`,`InvNo`,`CusCode`,`ChequeNo`,`ChequeRecDate`,`ChequeDate`,`ChequeReference`,`TotalPayment`,`CashPayment`,`ChequePayment`)

VALUES

(P_PaymentId,P_PaymentType,P_PayDate,P_PayAmount,P_InvNo,P_CusCode,P_ChequeNo,P_ChequeRecDate,P_ChequeDate,P_ChequeReference,P_PayAmount,P_CashAmount,P_ChequeAmount);



IF P_Over_PayAmount>0 THEN



INSERT INTO `sup_over_payment_dtl`

(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`)

VALUES

(P_PaymentId,P_PaymentType,P_Over_PayAmount,P_Over_PayInv);

END IF;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_SAVE_SUP_PAYMENT_DTL` (IN `P_PaymentId` VARCHAR(20), IN `P_PaymentType` VARCHAR(20), IN `P_InvNo` VARCHAR(20), IN `P_PayAmount` DECIMAL(20,2))  NO SQL BEGIN



INSERT INTO `supplier_payment_dtl`

(`PaymentId`,`PaymentType`,`PayAmount`,`InvNo`)

VALUES

(P_PaymentId,P_PaymentType,P_PayAmount,P_InvNo);



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_CUSOUTSTAND` (IN `P_SupCode` VARCHAR(10), IN `P_InvAmount` DECIMAL(20,2), IN `P_CreditAmount` DECIMAL(20,2))  NO SQL BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);



IF EXISTS (SELECT `CusCode` FROM `customeroutstanding` WHERE `CusCode`=P_SupCode) THEN



SELECT `CusTotalInvAmount` INTO @cus_settle_amount FROM `customeroutstanding` WHERE `CusCode`=P_SupCode;

SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_SupCode;



SET @cus_settle_amount=@cus_settle_amount+P_InvAmount;

SET @total_oustanding=@total_oustanding+P_CreditAmount;



UPDATE `customeroutstanding`

SET `CusTotalInvAmount`=@cus_settle_amount,`CusOustandingAmount`=@total_oustanding

WHERE `CusCode`=P_SupCode;



ELSE



INSERT INTO customeroutstanding (CusCode,CusTotalInvAmount,CusOustandingAmount,CusSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES (P_SupCode,P_InvAmount,P_CreditAmount,0.00,0.00,0.00);

END IF;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_CUSOUTSTAND_RBACK` (IN `P_SupCode` VARCHAR(10), IN `P_InvAmount` DECIMAL(20,2), IN `P_CreditAmount` DECIMAL(20,2), IN `P_IsPayment` TINYINT(1))  NO SQL BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_inv_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);



IF EXISTS (SELECT `CusCode` FROM `customeroutstanding` WHERE `CusCode`=P_SupCode) THEN



SELECT `CusSettlementAmount` INTO @cus_settle_amount FROM `customeroutstanding` WHERE `CusCode`=P_SupCode;

SELECT `CusOustandingAmount` INTO @total_oustanding FROM `customeroutstanding` WHERE `CusCode`=P_SupCode;

SELECT `CusTotalInvAmount` INTO @total_inv_amount FROM `customeroutstanding` WHERE `CusCode`=P_SupCode;



SET @cus_settle_amount=@cus_settle_amount-P_InvAmount;

SET @total_oustanding=@total_oustanding-P_CreditAmount;



IF P_IsPayment=1 THEN 

	UPDATE `customeroutstanding`

	SET `CusOustandingAmount`=@total_oustanding,`CusSettlementAmount`=@cus_settle_amount

	WHERE `CusCode`=P_SupCode;



ELSE

	UPDATE `customeroutstanding`

	SET `CusTotalInvAmount`=@total_inv_amount,`CusOustandingAmount`=@total_oustanding

	WHERE `CusCode`=P_SupCode;



END IF;



ELSE



INSERT INTO customeroutstanding (CusCode,CusTotalInvAmount,CusOustandingAmount,CusSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES (P_SupCode,P_InvAmount,P_CreditAmount,0.00,0.00,0.00);



END IF;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_DAILY_STOCK` (IN `P_StockDate` DATE, IN `P_user` VARCHAR(50), IN `P_now` DATETIME)  NO SQL BEGIN

DELETE FROM stockdate WHERE StockDate=P_StockDate;

INSERT INTO stockdate

           (`ProductCode`,`StockDate`,`Stock`,`Location`)

SELECT productstock.ProductCode , P_StockDate , productstock.Stock,productstock.Location

FROM productstock INNER JOIN productcondition ON productcondition.ProductCode=productstock.ProductCode

INNER JOIN product ON product.ProductCode=productstock.ProductCode

WHERE productcondition.IsSerial=1;



INSERT INTO stockdateuser (`id`,`lastupdate`,`user`,`comment`)

VALUES('',P_now,P_user,'');



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_DOWN` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_RentalDefault` DECIMAL(20,2), IN `P_WRentalDefault` DECIMAL(20,2), IN `P_TotalDue` DECIMAL(20,2), IN `P_SettleAmount` DECIMAL(20,2), IN `P_Month` DECIMAL(20,2), IN `P_IsPaid` TINYINT(1), IN `P_ExtAmount` DECIMAL(20,2))  NO SQL BEGIN

















UPDATE `down_payment_dtl`








SET `RentalDefault`=P_RentalDefault,`WRentalDefault`=P_WRentalDefault,`TotalDue`=P_TotalDue,`SettleAmount`=P_SettleAmount,`IsPaid`=P_IsPaid








WHERE `InvNo`=P_InvNo  AND `DwPayType`=P_Month;

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_PRICE_STOCK` (IN `ProCode` VARCHAR(10), IN `GrnQty` DECIMAL(20,2), IN `PriceLevel` TINYINT(3), IN `GrnUnitCost` DECIMAL(20,2), IN `UnitPrice` DECIMAL(20,2), IN `GrnLocation` TINYINT(2))  NO SQL BEGIN



DECLARE IS_TRUE TINYINT(1);

IF NOT EXISTS (SELECT `PSCode` FROM `pricestock` WHERE `PSLocation` = GrnLocation AND `PSPriceLevel` = PriceLevel AND `PSCode` = ProCode AND `Price` = UnitPrice) THEN



INSERT INTO `pricestock`

           (`PSCode`,`PSLocation`,`PSPriceLevel`,`Price`,`Stock`,`UnitCost`)

VALUES

           (ProCode,GrnLocation,PriceLevel,UnitPrice,GrnQty,GrnUnitCost);



ELSE

UPDATE `pricestock`

   SET `Stock` = (IFNULL(`Stock`,0) +  IFNULL(GrnQty,0))

 WHERE `PSCode` = ProCode AND `PSPriceLevel` = PriceLevel AND `PSLocation` = GrnLocation AND `Price` = UnitPrice;

END IF;



IF NOT EXISTS (SELECT `ProductCode` FROM `productprice` WHERE `ProductCode` = ProCode AND `PL_No` = PriceLevel) THEN



INSERT INTO `productprice` (`ProductCode`,`PL_No`,`ProductPrice`)

     VALUES (ProCode,PriceLevel,UnitPrice);



ELSE



SELECT Value INTO @IS_TRUE FROM `systemoptions` WHERE `ID` = 'M003';



IF @IS_TRUE = 1 THEN

UPDATE `productprice`

   SET `ProductPrice` = UnitPrice

WHERE  `ProductCode` = ProCode AND `PL_No` =PriceLevel;

END IF;



END IF;



END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_PRO_STOCK` (IN `ProCode` VARCHAR(10), IN `GrnQty` DECIMAL(20,2), IN `OpenStock` DECIMAL(20,2), IN `GrnLocation` TINYINT(2))  NO SQL BEGIN



IF NOT EXISTS (SELECT `ProductCode` FROM `productstock` WHERE `Location` = GrnLocation  AND `ProductCode` = ProCode) THEN

INSERT INTO `productstock`

           (`ProductCode`,`Location`,`Stock`,`OpenStock`,`Flag`)

VALUES

           (ProCode,GrnLocation,IFNULL(GrnQty,0),IFNULL(OpenStock,0),0);



ELSE

UPDATE productstock SET Stock = (IFNULL(Stock,0)+IFNULL(GrnQty ,0)) WHERE ProductCode=ProCode AND Location=GrnLocation;



END IF;

END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_RENTAL` (IN `P_InvNo` VARCHAR(20), IN `P_AccNo` VARCHAR(20), IN `P_RentalDefault` DECIMAL(20,2), IN `P_WRentalDefault` DECIMAL(20,2), IN `P_TotalDue` DECIMAL(20,2), IN `P_SettleAmount` DECIMAL(20,2), IN `P_Month` DECIMAL(20,2), IN `P_IsPaid` TINYINT(1), IN `P_ExtAmount` DECIMAL(20,2), IN `P_TotalPaid` DECIMAL(20,2), IN `P_TotalDueAmount` DECIMAL(20,2))  NO SQL BEGIN

















UPDATE `rental_payment_dtl`








SET `RentalDefault`=P_RentalDefault,`WRentalDefault`=P_WRentalDefault,`TotalDue`=P_TotalDue,`SettleAmount`=P_SettleAmount,`IsPaid`=P_IsPaid








WHERE `InvNo`=P_InvNo AND `AccNo`=P_AccNo AND `Month`=P_Month;

















UPDATE `invoice_hed` 








SET `TotalPaid`=P_TotalPaid,`TotalDue`=P_TotalDueAmount








WHERE `InvNo`=P_InvNo AND `AccNo`=P_AccNo;

















END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_SUPOUTSTAND` (IN `P_SupCode` VARCHAR(10), IN `P_InvAmount` DECIMAL(20,2), IN `P_IsPayment` TINYINT(1))  NO SQL BEGIN

DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

IF EXISTS (SELECT SupCode FROM supplieroustanding  WHERE SupCode =P_SupCode ) THEN

SELECT `SupTotalInvAmount` INTO @cus_settle_amount FROM `supplieroustanding` WHERE `SupCode`=P_SupCode;

SELECT `SupOustandingAmount` INTO @total_oustanding FROM `supplieroustanding` WHERE `SupCode`=P_SupCode;



SET @cus_settle_amount=@cus_settle_amount+P_InvAmount;

SET @total_oustanding=@total_oustanding+P_InvAmount;

IF P_IsPayment=0 THEN

	UPDATE `supplieroustanding`

	SET `SupTotalInvAmount`=@cus_settle_amount,`SupOustandingAmount`=@total_oustanding

	WHERE `SupCode`=P_SupCode;

ELSE

	UPDATE `supplieroustanding`

	SET `SupOustandingAmount`=@total_oustanding

	WHERE `SupCode`=P_SupCode;

END IF;

ELSE



INSERT INTO `supplieroustanding` (SupCode,SupTotalInvAmount,SupOustandingAmount,SupSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES(P_SupCode,P_InvAmount,P_InvAmount,0,0,0);

END IF;

END$$

CREATE DEFINER=`nsoftsoft`@`localhost` PROCEDURE `SPT_UPDATE_SUPOUTSTAND_RBACK` (IN `P_SupCode` VARCHAR(10), IN `P_InvAmount` DECIMAL(20,2), IN `P_CreditAmount` DECIMAL(20,2))  NO SQL BEGIN



DECLARE cus_settle_amount DECIMAL(20,2);

DECLARE total_oustanding DECIMAL(20,2);

DECLARE is_payment TINYINT(1);



IF EXISTS (SELECT `SupCode` FROM `supplieroustanding` WHERE `SupCode`=P_SupCode) THEN



SELECT `SupSettlementAmount` INTO @cus_settle_amount FROM `supplieroustanding` WHERE `SupCode`=P_SupCode;

SELECT `SupOustandingAmount` INTO @total_oustanding FROM `supplieroustanding` WHERE `SupCode`=P_SupCode;



SET @cus_settle_amount=@cus_settle_amount+P_CreditAmount;

SET @total_oustanding=@total_oustanding-P_CreditAmount;



UPDATE `supplieroustanding`

	SET `SupOustandingAmount`=@total_oustanding,`SupSettlementAmount`=@cus_settle_amount

	WHERE `SupCode`=P_SupCode;



ELSE



INSERT INTO `supplieroustanding` (SupCode,SupTotalInvAmount,SupOustandingAmount,SupSettlementAmount,OpenOustanding,OustandingDueAmount)

VALUES (P_SupCode,P_InvAmount,P_CreditAmount,0.00,0.00,0.00);

END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `AccId` int(11) DEFAULT NULL,
  `AccNo` varchar(15) NOT NULL DEFAULT '',
  `CusCode` varchar(10) DEFAULT NULL,
  `AccDate` datetime DEFAULT NULL,
  `AccType` tinyint(4) DEFAULT NULL,
  `ItemCategory` int(11) DEFAULT NULL,
  `CusNic` varchar(250) DEFAULT NULL,
  `Location` varchar(10) DEFAULT NULL,
  `Remark` varchar(100) DEFAULT NULL,
  `InvUser` int(11) DEFAULT NULL,
  `IsCreate` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `DepNo` int(11) NOT NULL,
  `Description` varchar(80) DEFAULT NULL,
  `Code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`DepNo`, `Description`, `Code`) VALUES
(1, 'Product', 'PRO'),
(2, 'Loan', 'LOO');

-- --------------------------------------------------------

--
-- Table structure for table `account_type_sub`
--

CREATE TABLE `account_type_sub` (
  `DepNo` int(11) NOT NULL,
  `SubDepNo` int(11) NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `account_type_sub`
--

INSERT INTO `account_type_sub` (`DepNo`, `SubDepNo`, `Description`, `Code`) VALUES
(1, 1, 'Easy Product', 'EP'),
(1, 2, 'Normal Product', 'NP'),
(2, 3, 'All Loan', 'AL');

-- --------------------------------------------------------

--
-- Table structure for table `acc_gurantee`
--

CREATE TABLE `acc_gurantee` (
  `AccNo` varchar(15) NOT NULL DEFAULT '',
  `GuranteeNic` varchar(10) NOT NULL DEFAULT '',
  `GuranteeNo` tinyint(4) NOT NULL DEFAULT 0,
  `GuranteeCode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_preferences`
--

CREATE TABLE `admin_preferences` (
  `id` tinyint(1) NOT NULL,
  `user_panel` tinyint(1) NOT NULL DEFAULT 0,
  `sidebar_form` tinyint(1) NOT NULL DEFAULT 0,
  `messages_menu` tinyint(1) NOT NULL DEFAULT 0,
  `notifications_menu` tinyint(1) NOT NULL DEFAULT 0,
  `tasks_menu` tinyint(1) NOT NULL DEFAULT 0,
  `user_menu` tinyint(1) NOT NULL DEFAULT 1,
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT 0,
  `transition_page` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`) VALUES
(1, 0, 0, 0, 1, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `BALANCE_ID` varchar(15) DEFAULT NULL,
  `BALANCE_DATE` datetime DEFAULT NULL,
  `CASHIER` varchar(15) DEFAULT NULL,
  `START_TIME` time DEFAULT NULL,
  `START_FLOT` decimal(18,2) DEFAULT NULL,
  `END_TIME` time DEFAULT NULL,
  `END_FLOT` decimal(18,2) DEFAULT NULL,
  `NET_AMOUNT` decimal(18,2) DEFAULT NULL,
  `CASH_SALES` decimal(18,2) DEFAULT NULL,
  `CREDIT_SALES` decimal(18,2) DEFAULT NULL,
  `CARD_SALES` decimal(18,2) DEFAULT NULL,
  `DISCOUNT` decimal(18,2) DEFAULT NULL,
  `CASH_IN` decimal(18,2) DEFAULT NULL,
  `CASH_OUT` decimal(18,2) DEFAULT NULL,
  `BALANCE_AMOUNT` decimal(18,2) DEFAULT NULL,
  `RETURN_AMOUNT` decimal(18,2) DEFAULT NULL,
  `CUSTOMER_PAYMENT` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `BankCode` varchar(20) NOT NULL,
  `BankName` varchar(60) DEFAULT NULL,
  `Remark` varchar(150) DEFAULT NULL,
  `IsActive` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`BankCode`, `BankName`, `Remark`, `IsActive`) VALUES
('7010', 'Bank of Ceylon', '', 1),
('7038', 'Standard Chartered Bank', '', 1),
('7047', 'CITI BANK', '', 1),
('7056', 'Commercial Bank PLC', '', 1),
('7074', 'Habib Bank Ltd', '', 1),
('7083', 'Hatton National Bank', '', 1),
('7092', 'Hongkong Shanghai Bank', '', 1),
('7108', 'Indian Bank', '', 1),
('7117', 'Indian Overseas Bank', '', 1),
('7135', 'Peoples Bank', '', 1),
('7144', 'State Bank of India', '', 1),
('7162', 'Nations Trust Bank PLC', '', 1),
('7205', 'Deutsche Bank', '', 1),
('7214', 'National Development Bank PLC', '', 1),
('7269', 'MCB Bank Ltd', '', 1),
('7278', 'Sampath Bank PLC', '', 1),
('7287', 'Seylan Bank PLC', '', 1),
('7296', 'Public Bank', '', 1),
('7302', 'Union Bank of Colombo PLC', '', 1),
('7311', 'Pan Asia Banking Corporation PLC', '', 1),
('7384', 'ICICI Bank Ltd', '', 1),
('7454', 'DFCC Vardhana Bank Ltd', '', 1),
('7463', 'Amana Bank', '', 1),
('7472', 'Axis Bank', '', 1),
('7719', 'National Savings Bank', '', 1),
('7728', 'Sanasa Development Bank', '', 1),
('7737', 'HDFC Bank', '', 1),
('8004', 'Central Bank of Sri Lanka', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `acc_id` tinyint(4) NOT NULL,
  `acc_bank` smallint(6) DEFAULT NULL,
  `acc_name` varchar(30) DEFAULT NULL,
  `acc_no` varchar(30) DEFAULT NULL,
  `acc_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank_account`
--

INSERT INTO `bank_account` (`acc_id`, `acc_bank`, `acc_name`, `acc_no`, `acc_active`) VALUES
(1, 7010, 'TestSaman', '1020203564', 1);

-- --------------------------------------------------------

--
-- Table structure for table `body_color`
--

CREATE TABLE `body_color` (
  `bodycolor_id` int(11) NOT NULL,
  `body_color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_address`
--

CREATE TABLE `branch_address` (
  `loc_id` tinyint(4) NOT NULL,
  `company_id` tinyint(1) NOT NULL,
  `AddressLine01` varchar(50) NOT NULL,
  `AddressLine02` varchar(50) NOT NULL,
  `AddressLine03` varchar(50) NOT NULL,
  `MobileNo` varchar(80) NOT NULL,
  `LanLineNo` varchar(40) NOT NULL,
  `Fax` varchar(30) NOT NULL,
  `Email01` varchar(60) NOT NULL,
  `NbtNo` varchar(50) DEFAULT NULL,
  `VatNo` varchar(60) DEFAULT NULL,
  `Web` varchar(50) DEFAULT NULL,
  `Logo` varchar(100) DEFAULT NULL,
  `IsActive` tinyint(4) NOT NULL,
  `SAdvisorName` varchar(100) DEFAULT NULL,
  `SAdvisorContact` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `branch_address`
--

INSERT INTO `branch_address` (`loc_id`, `company_id`, `AddressLine01`, `AddressLine02`, `AddressLine03`, `MobileNo`, `LanLineNo`, `Fax`, `Email01`, `NbtNo`, `VatNo`, `Web`, `Logo`, `IsActive`, `SAdvisorName`, `SAdvisorContact`) VALUES
(1, 1, 'L.39', 'Saddathissapura', 'Ampara', 'M : +94 77 846 3849', 'Tel : 011 XXXXXX ', '', '', NULL, NULL, NULL, 'logo.png', 0, 'Mr. Sathutu Lanka (Pvt) Ltd', '+94 77 846 3849');

-- --------------------------------------------------------

--
-- Table structure for table `cancelcustomerpayment`
--

CREATE TABLE `cancelcustomerpayment` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `PaymentNo` varchar(10) NOT NULL,
  `CusCode` varchar(10) NOT NULL,
  `CancelAmount` decimal(18,2) NOT NULL,
  `CancelRemark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancelcustomerpayment`
--

INSERT INTO `cancelcustomerpayment` (`AppNo`, `Location`, `CancelNo`, `CancelDate`, `PaymentNo`, `CusCode`, `CancelAmount`, `CancelRemark`, `CancelUser`) VALUES
(1, 1, 'CNL0001', '2025-08-30 00:00:00', 'CC0004', '10069', 1180.80, '', '1'),
(1, 1, 'CNL0002', '2025-08-30 00:00:00', 'CC0003', '10069', 3974.00, '', '1'),
(1, 1, 'CNL0003', '2025-09-01 00:00:00', 'CC0010', '10071', 2000.00, '', '1'),
(1, 1, 'CNL0004', '2025-09-01 00:00:00', 'CC0011', '10071', 5000.00, '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cancelgrn`
--

CREATE TABLE `cancelgrn` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `GRNNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancelgrn`
--

INSERT INTO `cancelgrn` (`AppNo`, `CancelNo`, `Location`, `CancelDate`, `GRNNo`, `Remark`, `CancelUser`) VALUES
(1, 'CGR0001', 1, '2025-08-21 00:00:00', 'GRN0010', '', '1'),
(1, 'CGR0002', 1, '2025-08-21 00:00:00', 'GRN0012', '', '1'),
(1, 'CGR0003', 1, '2025-09-02 00:00:00', 'GRN0028', '', '1'),
(1, 'CGR0004', 1, '2025-09-02 00:00:00', 'GRN0025', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cancelinvoice`
--

CREATE TABLE `cancelinvoice` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canceljobinvoice`
--

CREATE TABLE `canceljobinvoice` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `JobInvoiceNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canceljobinvpayment`
--

CREATE TABLE `canceljobinvpayment` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `JobInvoiceNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancelsalesinvoice`
--

CREATE TABLE `cancelsalesinvoice` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `SalesInvoiceNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cancelsalesinvoice`
--

INSERT INTO `cancelsalesinvoice` (`AppNo`, `CancelNo`, `Location`, `CancelDate`, `SalesInvoiceNo`, `Remark`, `CancelUser`) VALUES
(1, 'CSI0001', 1, '2025-08-21 10:17:42', 'WI0016', 'guifo', '1'),
(1, 'CSI0002', 1, '2025-08-28 13:05:57', 'AEC0018', 'N', '1'),
(1, 'CSI0003', 1, '2025-08-30 14:23:39', 'AEC0025', '-', '1'),
(1, 'CSI0004', 1, '2025-08-30 14:37:48', 'AEC0026', '-', '1'),
(1, 'CSI0005', 1, '2025-09-01 15:15:23', 'AEC0029', 'N', '1'),
(1, 'CSI0006', 1, '2025-09-01 15:19:20', 'AEC0028', 'N', '1');

-- --------------------------------------------------------

--
-- Table structure for table `cancelsupplierpayment`
--

CREATE TABLE `cancelsupplierpayment` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `PaymentNo` varchar(10) NOT NULL,
  `SupCode` varchar(10) NOT NULL,
  `CancelAmount` decimal(18,2) NOT NULL,
  `CancelRemark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canceltranser`
--

CREATE TABLE `canceltranser` (
  `AppNo` int(11) NOT NULL,
  `CancelNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CancelDate` datetime NOT NULL,
  `TRNNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `CancelUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashflot`
--

CREATE TABLE `cashflot` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `FlotNo` int(11) NOT NULL,
  `FlotDate` datetime NOT NULL,
  `DateORG` datetime NOT NULL,
  `Emp` varchar(10) DEFAULT '0',
  `TransactionCode` int(11) NOT NULL,
  `CounterNo` varchar(2) NOT NULL,
  `FlotAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(100) NOT NULL,
  `SystemUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashierbalancesheet`
--

CREATE TABLE `cashierbalancesheet` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `ID` varchar(16) NOT NULL,
  `SystemUser` varchar(15) NOT NULL,
  `BalanceDate` datetime NOT NULL,
  `StartTime` datetime NOT NULL,
  `StartFlot` decimal(18,2) NOT NULL,
  `EndTime` datetime NOT NULL,
  `EndFlot` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cashierbalancesheet`
--

INSERT INTO `cashierbalancesheet` (`AppNo`, `Location`, `ID`, `SystemUser`, `BalanceDate`, `StartTime`, `StartFlot`, `EndTime`, `EndFlot`) VALUES
(1, 1, '2025_08_12_13_0', '1', '2025-08-12 13:06:39', '2025-08-12 13:06:39', 1.00, '2025-08-12 13:06:39', 0.00),
(1, 1, '2025_08_13_11_4', '1', '2025-08-13 11:41:50', '2025-08-13 11:41:50', 1.00, '2025-08-13 11:41:50', 0.00),
(1, 1, '2025_08_19_15_4', '1', '2025-08-19 15:40:07', '2025-08-19 15:40:07', 1.00, '2025-08-19 15:40:07', 0.00),
(1, 1, '2025_08_20_10_2', '1', '2025-08-20 10:27:12', '2025-08-20 10:27:12', 100.00, '2025-08-20 10:27:12', 0.00),
(1, 1, '2025_08_21_10_1', '1', '2025-08-21 10:15:13', '2025-08-21 10:15:13', 1.00, '2025-08-21 10:15:13', 0.00),
(1, 1, '2025_08_26_14_0', '1', '2025-08-26 14:02:16', '2025-08-26 14:02:16', 1.00, '2025-08-26 14:02:16', 0.00),
(1, 1, '2025_08_27_14_0', '1', '2025-08-27 14:00:21', '2025-08-27 14:00:21', 1.00, '2025-08-27 14:00:21', 0.00),
(1, 1, '2025_08_28_11_1', '1', '2025-08-28 11:14:41', '2025-08-28 11:14:41', 1.00, '2025-08-28 11:14:41', 0.00),
(1, 1, '2025_08_29_15_1', '1', '2025-08-29 15:13:52', '2025-08-29 15:13:52', 1.00, '2025-08-29 15:13:52', 0.00),
(1, 1, '2025_08_30_09_1', '1', '2025-08-30 09:14:10', '2025-08-30 09:14:10', 1.00, '2025-08-30 09:14:10', 0.00),
(1, 1, '2025_09_01_09_5', '1', '2025-09-01 09:52:29', '2025-09-01 09:52:29', 1.00, '2025-09-01 09:52:29', 0.00),
(1, 1, '2025_09_02_09_5', '1', '2025-09-02 09:51:54', '2025-09-02 09:51:54', 1.00, '2025-09-02 09:51:54', 0.00),
(1, 1, '2025_09_03_09_4', '1', '2025-09-03 09:44:22', '2025-09-03 09:44:22', 1.00, '2025-09-03 09:44:22', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `cashinout`
--

CREATE TABLE `cashinout` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `Emp` varchar(7) DEFAULT '0',
  `InOutID` int(11) NOT NULL,
  `InOutDate` datetime NOT NULL,
  `TransCode` smallint(6) DEFAULT NULL,
  `SystemUser` varchar(15) NOT NULL,
  `Mode` varchar(3) NOT NULL,
  `CashAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(100) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `DepCode` smallint(6) NOT NULL,
  `SubDepCode` smallint(6) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`DepCode`, `SubDepCode`, `CategoryCode`, `Description`, `Flag`) VALUES
(4, 4, 1, '-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `charges_type`
--

CREATE TABLE `charges_type` (
  `charge_id` int(11) NOT NULL DEFAULT 0,
  `charge_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `charges_type`
--

INSERT INTO `charges_type` (`charge_id`, `charge_type`) VALUES
(1, 'Document '),
(2, 'Registration '),
(3, 'Insurance '),
(4, 'Service ');

-- --------------------------------------------------------

--
-- Table structure for table `chequedetails`
--

CREATE TABLE `chequedetails` (
  `AutoID` int(11) NOT NULL,
  `AppNo` int(11) NOT NULL,
  `ReceivedDate` datetime NOT NULL,
  `CusCode` varchar(10) NOT NULL,
  `ChequeOwner` varchar(100) DEFAULT NULL,
  `ReferenceNo` varchar(12) DEFAULT NULL,
  `BankNo` int(11) DEFAULT NULL,
  `ChequeNo` varchar(10) DEFAULT NULL,
  `ChequeDate` datetime DEFAULT NULL,
  `ChequeAmount` decimal(18,2) DEFAULT NULL,
  `Mode` varchar(40) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsRelease` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` tinyint(4) NOT NULL,
  `class_name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`) VALUES
(1, 'job'),
(2, 'pos'),
(3, 'salesinvoice'),
(4, 'invoice'),
(5, 'report'),
(6, 'transer'),
(7, 'payment'),
(8, 'grn'),
(9, 'users'),
(10, 'permission'),
(11, 'purchase');

-- --------------------------------------------------------

--
-- Table structure for table `class_function`
--

CREATE TABLE `class_function` (
  `function_id` tinyint(4) NOT NULL,
  `class_no` varchar(50) DEFAULT NULL,
  `function_name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `class_function`
--

INSERT INTO `class_function` (`function_id`, `class_no`, `function_name`) VALUES
(1, 'job', 'index'),
(2, 'salesinvoice', 'view_invoice'),
(3, 'salesinvoice', 'cancelInvoice'),
(4, 'payment', 'cancel_cus_payment'),
(5, 'payment', 'cancel_cus_payment'),
(6, 'invoice', 'cancel_invoice'),
(7, 'transer', 'cancel_transer'),
(8, 'grn', 'cancel_grn'),
(10, 'job', 'cancel_job'),
(11, 'users', 'edit'),
(12, 'users', 'index'),
(13, 'permission', 'user_permission'),
(14, 'users', 'create'),
(15, 'job', 'view_job'),
(16, 'pos', 'index'),
(17, 'report', 'salebydate');

-- --------------------------------------------------------

--
-- Table structure for table `clearproductlog`
--

CREATE TABLE `clearproductlog` (
  `ID` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `ProductCode` varchar(50) NOT NULL,
  `SerialNo` varchar(50) NOT NULL,
  `Stock` decimal(18,2) NOT NULL,
  `UpdateUser` varchar(50) NOT NULL,
  `SysDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clearseriallog`
--

CREATE TABLE `clearseriallog` (
  `ID` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `ProductCode` varchar(50) NOT NULL,
  `SerialNo` varchar(50) NOT NULL,
  `Stock` decimal(18,2) NOT NULL,
  `UpdateUser` varchar(50) NOT NULL,
  `SysDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `codegenerate`
--

CREATE TABLE `codegenerate` (
  `FormName` varchar(30) NOT NULL,
  `FormCode` varchar(4) NOT NULL,
  `AutoNumber` decimal(8,0) NOT NULL,
  `CodeLimit` varchar(8) NOT NULL,
  `FCLength` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `codegenerate`
--

INSERT INTO `codegenerate` (`FormName`, `FormCode`, `AutoNumber`, `CodeLimit`, `FCLength`) VALUES
('Account', '', 0, '00000000', 4),
('Adjustment', 'ADJ', 0, '00000000', 4),
('AutoSerial', '', 13610, '0', 8),
('Bank Acc Maintenance', 'ACC', 0, '00000000', 4),
('BatchNoWeb', 'BNM', 0, '00000000', 4),
('BinCard', '1', 0, '00000000', 8),
('BinCardOustanding', '1', 0, '00000000', 8),
('Cancel Cus Payments', 'CNL', 4, '00000000', 4),
('CancelGRN', 'CGR', 4, '0', 4),
('CancelInvoice', 'CAN', 0, '00000000', 4),
('CancelJobInvoice', 'CJI', 0, '0', 4),
('CancelJobInvPayment', 'CJP', 0, '0', 4),
('CancelSalesInvoice', 'CSI', 6, '0', 4),
('CancelSupPayment', 'CSP', 3, '00000000', 4),
('CequeDeposit', 'CD', 0, '00000000', 4),
('CreditInvoiceNo1', 'AEC', 42, '0', 4),
('CreditInvoiceNo2', 'AWC', 0, '0', 4),
('CreditInvoiceNo3', 'AAEC', 0, '0', 4),
('Custom', '', 0, '00000000', 4),
('Customer', '1', 71, '0', 4),
('Customer Advance', 'CAP', 0, '0', 4),
('Customer Open Outstanding', 'COB', 0, '0', 4),
('Customer Order', 'CO', 0, '00000000', 4),
('Customer Payment', 'CC', 12, '00000000', 4),
('Distribution', 'INV', 0, '00000000', 6),
('Distribution Credit', 'CINV', 0, '00000000', 5),
('DwPayNo', 'DP', 0, '00000000', 4),
('EstimateNumber1', 'AEE', 0, '0', 4),
('EstimateNumber2', 'AWE', 0, '0', 4),
('EstimateNumber3', 'AAEE', 0, '0', 4),
('GenaralEstimate', 'EG', 0, '0', 4),
('Goods Received Note', 'GRN', 31, '00000000', 4),
('HoldInvoice', 'HIV', 0, '00000000', 4),
('InsuranceEstimate', 'EI', 0, '0', 4),
('Internal Transfer', 'IT', 0, '00000000', 4),
('Invoice Return', 'RTN', 2, '00000000', 4),
('IssueNoteNo', 'ISN', 0, '00000000', 4),
('Job Form', 'JOB', 0, '00000000', 4),
('JobInvoice1', 'AEJI', 0, '0', 4),
('JobInvoice2', 'AWJI', 0, '0', 4),
('JobInvoice3', 'AAEJ', 0, '0', 4),
('JobInvoiceInsurance', 'II', 0, '0', 4),
('JobNumber1', 'AEJ', 0, '0', 4),
('JobNumber2', 'AWJ', 0, '0', 4),
('JobNumber3', 'AAEJ', 0, '0', 4),
('JobNumberInsurance', 'JI', 0, '0', 4),
('JobPackage', 'PKG', 0, '0', 4),
('JobPackage2', 'SPK', 0, '0', 4),
('LoanHead', 'LON', 0, '00000000', 4),
('LoanInvoiceNo', 'LIN', 0, '00000000', 4),
('LoanPaymentNo', 'LP', 0, '00000000', 4),
('MapTransaction', 'MAP', 0, '00000000', 4),
('MRN', 'PR', 0, '0', 4),
('M_GRN', 'MIN', 0, '00000000', 4),
('Point Of Sales Credit', 'CRCP', 0, '00000000', 5),
('Point Of Sales1', 'RCP', 0, '0', 6),
('Point Of Sales2', 'SRC', 0, '0', 6),
('PRN', 'PRN', 8, '00000000', 4),
('Product', '1', 77, '0', 5),
('Purchase Order', 'PON', 0, '00000000', 4),
('Recipe', 'RCP', 0, '00000000', 4),
('RepID', '', 0, '00000000', 4),
('SalesInvoiceNo1', 'WI', 17, '0', 4),
('SalesInvoiceNo2', 'AW', 0, '0', 4),
('SalesInvoiceNo3', 'AAE', 0, '0', 4),
('salespersons', 'EMP', 12, '0', 4),
('Supplier', 'SUP', 21, '00000000', 4),
('Supplier Open Outstanding', 'SOB', 7, '0', 4),
('Supplier Payment', 'SPM', 3, '00000000', 4),
('TempJobInvoice1', 'AET', 0, '0', 4),
('TempJobInvoice2', 'AWT', 0, '0', 4),
('TempJobInvoice3', 'AAET', 0, '0', 4),
('TempSalesInvoice', 'TSE', 77, '0', 4),
('Transfer Cancel', 'CTR', 0, '0', 4),
('Transfer Out', 'TRN', 0, '00000000', 4),
('TrnsSteps', 'TNS', 0, '00000000', 4),
('UnitMap', 'UMP', 0, '00000000', 4),
('Update Fuel', 'FUP', 0, '00000000', 4),
('Wastage', 'WN', 0, '00000000', 4);

-- --------------------------------------------------------

--
-- Table structure for table `code_genarate`
--

CREATE TABLE `code_genarate` (
  `RefId` tinyint(4) NOT NULL,
  `RefType` varchar(10) DEFAULT NULL,
  `TotalLength` tinyint(4) DEFAULT NULL,
  `String` varchar(10) DEFAULT NULL,
  `StringLength` tinyint(4) DEFAULT NULL,
  `Code` varchar(5) DEFAULT NULL,
  `CodeLength` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `code_genarate`
--

INSERT INTO `code_genarate` (`RefId`, `RefType`, `TotalLength`, `String`, `StringLength`, `Code`, `CodeLength`) VALUES
(1, 'ItemCode', 7, 'GM', 2, '0', 3),
(2, 'BatchNo', 7, 'LT', 2, '0', 3),
(3, 'InvoiceNo', 8, 'INV', 3, '0', 3),
(4, 'TransferNo', 7, 'TRN', 3, '0', 3),
(5, 'PaymentNo', 7, 'EP', 2, '0', 3),
(6, 'CreditNo', 8, 'CIN', 3, '0', 3),
(7, 'AccountNo', 5, NULL, 0, '0', 5),
(8, 'GRNNo', 8, 'GRN', 2, '0', 3),
(9, 'DwPayNo', 7, 'DP', 2, '0', 3),
(10, 'SupPayNo', 7, 'SP', 2, '0', 3),
(11, 'NormalPay', 7, 'NP', 2, '0', 3),
(12, 'SeettuID', 7, 'SC', 2, '0', 3);

-- --------------------------------------------------------

--
-- Table structure for table `comission`
--

CREATE TABLE `comission` (
  `id` tinyint(4) NOT NULL DEFAULT 0,
  `name` varchar(20) DEFAULT NULL,
  `depCode` smallint(6) DEFAULT NULL,
  `subCatCode` smallint(6) DEFAULT NULL,
  `comission` decimal(10,2) DEFAULT NULL,
  `isBackComis` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `CompanyID` varchar(20) NOT NULL,
  `CompanyName` varchar(150) NOT NULL,
  `CompanyName2` varchar(100) DEFAULT NULL,
  `RegNo` varchar(50) NOT NULL,
  `AddressLine01` varchar(50) NOT NULL,
  `AddressLine02` varchar(50) NOT NULL,
  `AddressLine03` varchar(50) NOT NULL,
  `MobileNo` varchar(40) NOT NULL,
  `LanLineNo` varchar(40) NOT NULL,
  `Fax` varchar(30) NOT NULL,
  `Email01` varchar(60) NOT NULL,
  `Email02` varchar(60) DEFAULT NULL,
  `Logo` varchar(100) DEFAULT NULL,
  `IsActive` tinyint(4) NOT NULL,
  `MonthEnd` date NOT NULL,
  `A5Print` tinyint(1) DEFAULT NULL,
  `SAdvisorName` varchar(100) DEFAULT NULL,
  `SAdvisorContact` varchar(50) DEFAULT NULL,
  `VAT` decimal(5,2) DEFAULT NULL,
  `NBT` decimal(5,2) DEFAULT NULL,
  `NBT_Ratio` decimal(5,2) DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`CompanyID`, `CompanyName`, `CompanyName2`, `RegNo`, `AddressLine01`, `AddressLine02`, `AddressLine03`, `MobileNo`, `LanLineNo`, `Fax`, `Email01`, `Email02`, `Logo`, `IsActive`, `MonthEnd`, `A5Print`, `SAdvisorName`, `SAdvisorContact`, `VAT`, `NBT`, `NBT_Ratio`) VALUES
('1', 'Sathutu Lanka (Pvt) Ltd', '', '', 'L.39,Saddathissapura', 'Ampara', '', '+94 77 846 3849', '', '', '\r\n', '', 'logo.png', 1, '2021-08-20', 0, 'Mr.', '0', 8.00, 0.00, 0.50);

-- --------------------------------------------------------

--
-- Table structure for table `companycreditinvoicedetails`
--

CREATE TABLE `companycreditinvoicedetails` (
  `AppNo` smallint(6) NOT NULL,
  `ComInvoiceDate` datetime NOT NULL,
  `ComInvoiceNo` varchar(10) NOT NULL,
  `ComLocation` smallint(6) NOT NULL,
  `ComCusCode` varchar(10) NOT NULL,
  `ComNetAmount` decimal(18,2) NOT NULL,
  `ComCreditAmount` decimal(18,2) NOT NULL,
  `ComSettledAmount` decimal(18,2) NOT NULL,
  `ComIsCloseInvoice` tinyint(4) NOT NULL,
  `ComIsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creditcardtypes`
--

CREATE TABLE `creditcardtypes` (
  `Card_Type` varchar(20) NOT NULL,
  `Card_Remark` varchar(50) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `creditcardtypes`
--

INSERT INTO `creditcardtypes` (`Card_Type`, `Card_Remark`, `IsActive`) VALUES
('Amex', '', 1),
('Master', '', 1),
('Visa', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `creditgrndetails`
--

CREATE TABLE `creditgrndetails` (
  `AppNo` smallint(6) NOT NULL,
  `GRNDate` datetime NOT NULL,
  `GRNNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `SupCode` varchar(10) NOT NULL,
  `NetAmount` decimal(18,2) NOT NULL,
  `CreditAmount` decimal(18,2) NOT NULL,
  `SettledAmount` decimal(18,2) NOT NULL,
  `IsCloseGRN` tinyint(4) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `creditgrndetails`
--

INSERT INTO `creditgrndetails` (`AppNo`, `GRNDate`, `GRNNo`, `Location`, `SupCode`, `NetAmount`, `CreditAmount`, `SettledAmount`, `IsCloseGRN`, `IsCancel`) VALUES
(1, '2025-08-13 00:00:00', 'GRN0004', 1, 'SUP0013', 250.00, 250.00, 0.00, 0, 0),
(1, '2025-08-13 00:00:00', 'GRN0005', 1, 'SUP0013', 4826880.00, 4826880.00, 0.00, 0, 0),
(1, '2025-08-13 00:00:00', 'GRN0006', 1, 'SUP0013', 2441000.00, 2441000.00, 0.00, 0, 0),
(1, '2025-08-13 00:00:00', 'GRN0007', 1, 'SUP0013', 708000.00, 708000.00, 0.00, 0, 0),
(1, '2025-08-13 00:00:00', 'GRN0008', 1, 'SUP0020', 155.54, 155.54, 0.00, 0, 0),
(1, '2025-08-21 00:00:00', 'GRN0009', 1, 'SUP0014', 500.00, 500.00, 0.00, 0, 0),
(1, '2025-08-21 00:00:00', 'GRN0010', 1, 'SUP0014', 700.00, 700.00, 0.00, 0, 1),
(1, '2025-08-21 00:00:00', 'GRN0011', 1, 'SUP0014', 700.00, 700.00, 0.00, 0, 0),
(1, '2025-08-21 00:00:00', 'GRN0012', 1, 'SUP0014', 1000.00, 1000.00, 0.00, 0, 1),
(1, '2025-08-26 00:00:00', 'GRN0013', 1, 'SUP0013', 51000.00, 51000.00, 0.00, 0, 0),
(1, '2025-08-28 00:00:00', 'GRN0014', 1, 'SUP0021', 2000.00, 2000.00, 2000.00, 1, 0),
(1, '2025-08-28 00:00:00', 'GRN0015', 1, 'SUP0021', 1200.00, 1200.00, 1200.00, 1, 0),
(1, '2025-08-30 00:00:00', 'GRN0016', 1, 'SUP0014', 500.00, 500.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0017', 1, 'SUP0012', 600.00, 600.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0018', 1, 'SUP0012', 2500.00, 2500.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0019', 1, 'SUP0012', 400.00, 400.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0020', 1, 'SUP0012', 350.00, 350.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0021', 1, 'SUP0012', 400.00, 400.00, 0.00, 0, 0),
(1, '2025-08-30 00:00:00', 'GRN0022', 1, 'SUP0012', 600.00, 600.00, 0.00, 0, 0),
(1, '2025-09-01 00:00:00', 'GRN0023', 1, 'SUP0021', 3000.00, 3000.00, 3000.00, 1, 0),
(1, '2025-09-01 00:00:00', 'GRN0024', 1, 'SUP0021', 5100.00, 5100.00, 5100.00, 1, 0),
(1, '2025-09-01 00:00:00', 'GRN0025', 1, 'SUP0021', 500.00, 500.00, 500.00, 1, 1),
(1, '2025-09-02 00:00:00', 'GRN0026', 1, 'SUP0021', 700.00, 700.00, 100.00, 0, 0),
(1, '2025-09-02 00:00:00', 'GRN0027', 1, 'SUP0021', 500.00, 500.00, 0.00, 0, 0),
(1, '2025-09-02 00:00:00', 'GRN0028', 1, 'SUP0021', 700.00, 700.00, 0.00, 0, 1),
(1, '2025-09-02 00:00:00', 'GRN0029', 1, 'SUP0021', 700.00, 700.00, 0.00, 0, 0),
(1, '2025-09-02 00:00:00', 'GRN0030', 1, 'SUP0021', 800.00, 800.00, 0.00, 0, 0),
(1, '2025-09-02 00:00:00', 'GRN0031', 1, 'SUP0021', 1800.00, 1800.00, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `creditinvoicedetails`
--

CREATE TABLE `creditinvoicedetails` (
  `AppNo` smallint(6) NOT NULL,
  `Type` tinyint(1) NOT NULL DEFAULT 0,
  `InvoiceDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CusCode` varchar(10) NOT NULL,
  `NetAmount` decimal(18,2) NOT NULL,
  `CreditAmount` decimal(18,2) NOT NULL,
  `SettledAmount` decimal(18,2) DEFAULT 0.00,
  `returnAmount` decimal(18,2) NOT NULL,
  `IsCloseInvoice` tinyint(4) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `creditinvoicedetails`
--

INSERT INTO `creditinvoicedetails` (`AppNo`, `Type`, `InvoiceDate`, `InvoiceNo`, `Location`, `CusCode`, `NetAmount`, `CreditAmount`, `SettledAmount`, `returnAmount`, `IsCloseInvoice`, `IsCancel`) VALUES
(1, 1, '2025-08-12 13:16:28', 'AEC0001', 1, '10062', 111.46, 111.46, 111.46, 0.00, 1, 0),
(1, 1, '2025-08-12 13:23:25', 'AEC0002', 1, '10001', 111.00, 100.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-12 13:36:19', 'AEC0003', 1, '10002', 111.00, 111.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-12 14:23:30', 'AEC0004', 1, '10002', 111.00, 100.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-12 15:04:28', 'AEC0005', 1, '10001', 111.00, 100.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-13 12:28:15', 'AEC0006', 1, '10021', 1300.00, 1300.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-13 12:29:23', 'AEC0007', 1, '10001', 111.00, 111.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-13 12:32:22', 'AEC0008', 1, '10002', 165.00, 85.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-13 13:43:35', 'AEC0009', 1, '10001', 91.00, 91.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-21 14:05:59', 'AEC0010', 1, '10062', 3126.93, 3126.93, 3126.93, 0.00, 1, 0),
(1, 1, '2025-08-21 14:57:33', 'AEC0011', 1, '10062', 80.00, 80.00, 80.00, 0.00, 1, 0),
(1, 1, '2025-08-21 15:02:55', 'AEC0012', 1, '10062', 1350.00, 1350.00, 1350.00, 0.00, 1, 0),
(1, 1, '2025-08-26 14:03:01', 'AEC0013', 1, '10002', 18320.00, 18320.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-26 14:19:51', 'AEC0014', 1, '10001', 1099.20, 1099.20, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-27 14:00:34', 'AEC0015', 1, '10001', 183.20, 183.20, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-27 15:49:57', 'AEC0016', 1, '10003', 549.60, 549.60, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-28 12:51:03', 'AEC0017', 1, '10064', 900.00, 900.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-28 13:02:25', 'AEC0018', 1, '10064', 432.00, 432.00, 0.00, 0.00, 0, 1),
(1, 1, '2025-08-28 17:05:22', 'AEC0019', 1, '10015', 641.20, 641.20, 600.00, 0.00, 0, 0),
(1, 1, '2025-08-29 15:23:24', 'AEC0020', 1, '10065', 1180.80, 1180.80, 0.00, 0.00, 0, 0),
(1, 1, '2025-08-30 09:22:06', 'AEC0021', 1, '10064', 2380.05, 2380.05, 2380.05, 0.00, 1, 0),
(1, 1, '2025-08-30 09:38:36', 'AEC0022', 1, '10069', 3720.00, 3720.00, 3720.00, 0.00, 1, 0),
(1, 1, '2025-08-30 09:50:02', 'AEC0023', 1, '10069', 253.75, 253.75, 260.00, 0.00, 1, 0),
(1, 1, '2025-08-30 12:43:01', 'AEC0024', 1, '10040', 372.00, 372.00, 372.00, 0.00, 1, 0),
(1, 1, '2025-08-30 14:19:50', 'AEC0025', 1, '10065', 2750.00, 2750.00, 0.00, 0.00, 0, 1),
(1, 1, '2025-08-30 14:35:48', 'AEC0026', 1, '10065', 2750.00, 2750.00, 0.00, 0.00, 0, 1),
(1, 1, '2025-09-01 09:54:16', 'AEC0027', 1, '10070', 450.00, 450.00, 450.00, 0.00, 1, 0),
(1, 1, '2025-09-01 13:56:09', 'AEC0028', 1, '10071', 2450.00, 1950.00, 0.00, 0.00, 0, 1),
(1, 1, '2025-09-01 14:59:18', 'AEC0029', 1, '10071', 2600.00, 2600.00, 0.00, 0.00, 0, 1),
(1, 1, '2025-09-02 09:53:01', 'AEC0030', 1, '10071', 1625.00, 1625.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 10:39:35', 'AEC0031', 1, '10071', 600.00, 600.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 15:14:34', 'AEC0032', 1, '10071', 1100.00, 1100.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 15:19:53', 'AEC0033', 1, '10071', 2600.00, 2600.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 15:43:44', 'AEC0034', 1, '10071', 1000.00, 1000.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 15:58:10', 'AEC0035', 1, '10071', 2340.00, 2340.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 15:58:24', 'AEC0036', 1, '10071', 2340.00, 2340.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 16:00:16', 'AEC0037', 1, '10071', 2340.00, 2340.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 16:02:11', 'AEC0038', 1, '10071', 110.00, 110.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 16:15:55', 'AEC0039', 1, '10071', 4000.00, 3000.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-02 16:16:59', 'AEC0040', 1, '10071', 3580.00, 2580.00, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-03 12:19:29', 'AEC0041', 1, '10018', 191060.84, 191060.84, 0.00, 0.00, 0, 0),
(1, 1, '2025-09-03 12:59:21', 'AEC0042', 1, '10062', 4051.50, 3651.50, 0.00, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CusCode` int(11) NOT NULL,
  `OldCode` bigint(20) DEFAULT NULL,
  `CusBookNo` varchar(10) DEFAULT NULL,
  `DisType` tinyint(1) DEFAULT 1,
  `RespectSign` varchar(10) NOT NULL,
  `CusName` varchar(60) NOT NULL,
  `DisplayName` varchar(60) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `JoinDate` datetime NOT NULL,
  `RootNo` smallint(6) NOT NULL,
  `Address01` varchar(150) NOT NULL,
  `Address02` varchar(30) NOT NULL,
  `Address03` varchar(30) NOT NULL,
  `ComAddress` varchar(150) DEFAULT NULL,
  `MobileNo` varchar(18) NOT NULL,
  `WorkNo` varchar(12) DEFAULT NULL,
  `LanLineNo` varchar(18) NOT NULL,
  `Fax` varchar(18) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `IsAllowCredit` tinyint(4) NOT NULL,
  `CreditLimit` decimal(18,2) NOT NULL,
  `CreditPeriod` smallint(6) NOT NULL,
  `IsLoyalty` tinyint(4) NOT NULL,
  `LoyaltyNo` varchar(20) NOT NULL,
  `IsVat` tinyint(4) DEFAULT NULL,
  `VatNumber` varchar(30) DEFAULT NULL,
  `ContactPerson` varchar(30) DEFAULT NULL,
  `ContactNo` varchar(12) DEFAULT NULL,
  `IsActive` tinyint(4) NOT NULL,
  `Flag` tinyint(4) NOT NULL,
  `BalanceDate` date DEFAULT NULL,
  `BalanaceAmount` decimal(18,2) NOT NULL,
  `payMethod` tinyint(4) DEFAULT NULL,
  `CusType` tinyint(1) DEFAULT NULL,
  `CusCompany` varchar(100) DEFAULT NULL,
  `DocNo` varchar(20) DEFAULT NULL,
  `HandelBy` varchar(10) DEFAULT NULL,
  `CusCategory` varchar(10) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `IsSyn` tinyint(4) NOT NULL,
  `IsDelete` tinyint(4) NOT NULL,
  `CusType_easy` tinyint(4) NOT NULL,
  `IsEasy` tinyint(4) NOT NULL,
  `Nic` varchar(50) NOT NULL,
  `RouteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CusCode`, `OldCode`, `CusBookNo`, `DisType`, `RespectSign`, `CusName`, `DisplayName`, `LastName`, `JoinDate`, `RootNo`, `Address01`, `Address02`, `Address03`, `ComAddress`, `MobileNo`, `WorkNo`, `LanLineNo`, `Fax`, `Email`, `IsAllowCredit`, `CreditLimit`, `CreditPeriod`, `IsLoyalty`, `LoyaltyNo`, `IsVat`, `VatNumber`, `ContactPerson`, `ContactNo`, `IsActive`, `Flag`, `BalanceDate`, `BalanaceAmount`, `payMethod`, `CusType`, `CusCompany`, `DocNo`, `HandelBy`, `CusCategory`, `remark`, `IsSyn`, `IsDelete`, `CusType_easy`, `IsEasy`, `Nic`, `RouteId`) VALUES
(10001, NULL, '', 1, 'M/S', 'New City Super Market', 'M/S. New City Super Market', '', '2025-06-25 03:10:51', 0, 'No 03,\r\nD.S.Senanayake Street,\r\nAmpara.', '', '', '', '+94632222493', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-06-25', 0.00, 0, 1, '-', '', 'EMP0002', '0', 'qwertyujkhgrf', 0, 0, 1, 0, '-', 1),
(10002, NULL, '', 1, 'M/S', 'Jayalath Stores', 'M/S. Jayalath Stores', '', '2025-06-25 03:15:54', 0, 'Browns Junction,\r\nAmpara.', '', '', '', '+94000000000', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-06-25', 0.00, 1, 1, '-', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10003, NULL, '', 1, 'M/S', 'Hospital Canteen Outside', 'M/S. Hospital Canteen Outside', '', '2025-06-25 03:16:05', 0, 'Ampara', '', '', '', '+94778463849', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, 'Mr.Kapila', '+94', 1, 0, '2025-06-25', 0.00, 2, 1, '', '', 'EMP0003', '0', '', 0, 0, 1, 0, '-', 1),
(10004, NULL, '', 1, 'Mrs', 'Karuna Stores', 'Mrs. Karuna Stores', '', '2025-06-25 03:26:07', 0, '', '', '', '', '+94775419079', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-06-25', 0.00, 1, 1, '', '', 'EMP0002', '0', '', 0, 0, 1, 0, '-', 6),
(10005, NULL, '', 1, 'Mr', 'Indumathi Stores', 'Mr. Indumathi Stores', '', '2025-07-01 03:14:44', 0, '', '', '', '', '+94766701622', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-01', 0.00, 2, 1, '', '', 'EMP0002', '0', '', 0, 0, 1, 0, '-', 6),
(10006, NULL, '', 1, 'Mr', 'Nawa Stores', 'Mr. Nawa Stores', '', '2025-07-06 03:44:10', 0, '', '', '', '', '+94778682035', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-06', 0.00, 1, 1, '', '', 'EMP0002', '0', '', 0, 0, 1, 0, '-', 6),
(10007, NULL, '', 1, 'Mr', 'Darmalingam Stores', 'Mr. Darmalingam Stores', '', '2025-07-07 03:53:47', 0, '', '', '', '', '+94775334176', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-07', 0.00, 1, 1, '', '', 'EMP0002', '0', '', 0, 0, 1, 1, '-', 6),
(10008, NULL, '', 1, 'Mr', 'Saliya Stores', 'Mr. Saliya Stores', '', '2025-07-07 04:20:19', 0, '', '', '', '', '+94774065444', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-07', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10009, NULL, '', 1, 'M/S', 'K P Stores', 'M/S. K P Stores', '', '2025-07-09 06:27:56', 0, '', '', '', '', '+94712407812', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 3, '', '', 'EMP0001', '0', '', 0, 0, 3, 0, '-', 6),
(10010, NULL, '', 1, 'M/S', 'Devi Stores', 'M/S. Devi Stores', '', '2025-07-09 06:28:59', 0, '', '', '', '', '+94754699287', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10011, NULL, '', 1, 'M/S', 'Raja Stores', 'M/S. Raja Stores', '', '2025-07-09 06:29:50', 0, '', '', '', '', '+94753630260', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10012, NULL, '', 1, 'M/S', 'Sadesh Stores', 'M/S. Sadesh Stores', '', '2025-07-09 06:30:50', 0, '', '', '', '', '+94759898804', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10013, NULL, '', 1, 'M/S', 'Kumar Hotel', 'M/S. Kumar Hotel', '', '2025-07-09 06:31:55', 0, '', '', '', '', '+94765228371', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10014, NULL, '', 1, 'M/S', 'S P V Family Mart', 'M/S. S P V Family Mart', '', '2025-07-09 06:33:05', 0, '', '', '', '', '+94767000844', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 6),
(10015, NULL, '', 1, 'M/S', 'M G Stores', 'M/S. M G Stores', '', '2025-07-09 06:33:55', 0, '', '', '', '', '+94726005629', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 2, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10016, NULL, '', 1, 'M/S', 'Jayathilaka Stores', 'M/S. Jayathilaka Stores', '', '2025-07-09 06:35:23', 0, '', '', '', '', '+94632223887', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10017, NULL, '', 1, 'M/S', 'Rathna Super', 'M/S. Rathna Super', '', '2025-07-09 06:36:22', 0, '', '', '', '', '+94632222764', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10018, NULL, '', 1, 'M/S', 'Jaya Sri Hotel', 'M/S. Jaya Sri Hotel', '', '2025-07-09 06:37:22', 0, '', '', '', '', '+94771283797', '+94', '+94', '', '', 0, 500000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10019, NULL, '', 1, 'M/S', 'Shanthapriya Stores', 'M/S. Shanthapriya Stores', '', '2025-07-09 06:38:33', 0, '', '', '', '', '+94718034967', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10020, NULL, '', 1, 'M/S', 'Manoj Stores', 'M/S. Manoj Stores', '', '2025-07-09 06:39:29', 0, '', '', '', '', '+94719156729', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10021, NULL, '', 1, 'M/S', 'Chaminda Stores', 'M/S. Chaminda Stores', '', '2025-07-09 06:40:21', 0, '', '', '', '', '+94770303650', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10022, NULL, '', 1, 'M/S', 'Nishadi Grocery', 'M/S. Nishadi Grocery', '', '2025-07-09 06:42:30', 0, '', '', '', '', '+94710292031', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10023, NULL, '', 1, 'M/S', 'Isuru Stores', 'M/S. Isuru Stores', '', '2025-07-09 06:43:23', 0, '', '', '', '', '+94771528229', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10024, NULL, '', 1, 'M/S', 'Manjula Stores', 'M/S. Manjula Stores', '', '2025-07-09 06:44:30', 0, '', '', '', '', '+94767356123', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10025, NULL, '', 1, 'M/S', 'City Stores', 'M/S. City Stores', '', '2025-07-09 06:45:16', 0, '', '', '', '', '+94632222362', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10026, NULL, '', 1, 'M/S', 'Eat Right Food Cabin', 'M/S. Eat Right Food Cabin', '', '2025-07-09 06:46:20', 0, '', '', '', '', '+94772034762', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10027, NULL, '', 1, 'M/S', 'Eat Right Cafe', 'M/S. Eat Right Cafe', '', '2025-07-09 06:47:08', 0, '', '', '', '', '+94772034762', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10028, NULL, '', 1, 'M/S', 'Vidusara Stores', 'M/S. Vidusara Stores', '', '2025-07-09 06:48:29', 0, '', '', '', '', '+94632223293', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10029, NULL, '', 1, 'M/S', 'Book Mart and Fancy Fair', 'M/S. Book Mart and Fancy Fair', '', '2025-07-09 06:49:28', 0, '', '', '', '', '+94715847368', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10030, NULL, '', 1, 'M/S', 'Gamage Stores', 'M/S. Gamage Stores', '', '2025-07-09 06:50:19', 0, '', '', '', '', '+94710310715', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10031, NULL, '', 1, 'M/S', 'Nimnadi Stores', 'M/S. Nimnadi Stores', '', '2025-07-09 06:51:11', 0, '', '', '', '', '+94789558510', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10032, NULL, '', 1, 'M/S', 'Bhagya Stores', 'M/S. Bhagya Stores', '', '2025-07-09 06:52:09', 0, '', '', '', '', '+94000000000', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10033, NULL, '', 1, 'M/S', 'kumari Stores', 'M/S. kumari Stores', '', '2025-07-09 06:53:09', 0, '', '', '', '', '+94777349703', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10034, NULL, '', 1, 'M/S', 'City Traders', 'M/S. City Traders', '', '2025-07-09 06:54:27', 0, '', '', '', '', '+94632223336', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10035, NULL, '', 1, 'M/S', 'Food Delight', 'M/S. Food Delight', '', '2025-07-09 06:56:43', 0, '', '', '', '', '+94777469556', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10036, NULL, '', 1, 'M/S', 'K W S Karawala Kade', 'M/S. K W S Karawala Kade', '', '2025-07-09 06:57:42', 0, '', '', '', '', '+94702481682', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10037, NULL, '', 1, 'M/S', 'Sasmiru Super', 'M/S. Sasmiru Super', '', '2025-07-09 06:58:41', 0, '', '', '', '', '+94778325849', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10038, NULL, '', 1, 'M/S', 'Keshan Grocery', 'M/S. Keshan Grocery', '', '2025-07-09 06:59:32', 0, '', '', '', '', '+94776352415', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10039, NULL, '', 1, 'M/S', 'Chandana Stores', 'M/S. Chandana Stores', '', '2025-07-09 07:00:28', 0, '', '', '', '', '+94756324324', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10040, NULL, '', 1, 'M/S', 'Mithuru hotel', 'M/S. Mithuru hotel', '', '2025-07-09 07:01:22', 0, '', '', '', '', '+94788294095', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10041, NULL, '', 1, 'M/S', 'Nethu cool Spot And Grocery', 'M/S. Nethu cool Spot And Grocery', '', '2025-07-09 07:02:37', 0, '', '', '', '', '+94726698342', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10042, NULL, '', 1, 'M/S', 'Aswer Hotel', 'M/S. Aswer Hotel', '', '2025-07-09 07:03:32', 0, '', '', '', '', '+94777140910', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10043, NULL, '', 1, 'M/S', 'Suwarasa Grocery', 'M/S. Suwarasa Grocery', '', '2025-07-09 07:04:21', 0, '', '', '', '', '+94711344145', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 1),
(10044, NULL, '', 1, 'M/S', 'A R R Grocery', 'M/S. A R R Grocery', '', '2025-07-09 07:05:19', 0, '', '', '', '', '+94776302318', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10045, NULL, '', 1, 'M/S', 'Hizam Stores', 'M/S. Hizam Stores', '', '2025-07-09 07:06:06', 0, '', '', '', '', '+94754999510', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10046, NULL, '', 1, 'M/S', 'Nuha Stores', 'M/S. Nuha Stores', '', '2025-07-09 07:07:21', 0, '', '', '', '', '+94757655813', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10047, NULL, '', 1, 'M/S', 'Irfath Hotel', 'M/S. Irfath Hotel', '', '2025-07-09 07:08:20', 0, '', '', '', '', '+94750573986', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10048, NULL, '', 1, 'M/S', 'Zeenath Family Mart', 'M/S. Zeenath Family Mart', '', '2025-07-09 07:09:23', 0, '', '', '', '', '+94756141231', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10049, NULL, '', 1, 'M/S', 'M H Stores', 'M/S. M H Stores', '', '2025-07-09 07:10:33', 0, '', '', '', '', '+94754137176', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10050, NULL, '', 1, 'M/S', 'A K Y Multi Shop', 'M/S. A K Y Multi Shop', '', '2025-07-09 07:11:45', 0, '', '', '', '', '+94750128891', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10051, NULL, '', 1, 'M/S', 'S R A Mini Mart', 'M/S. S R A Mini Mart', '', '2025-07-09 07:12:48', 0, '', '', '', '', '+94777791874', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10052, NULL, '', 1, 'M/S', 'Rias Stores', 'M/S. Rias Stores', '', '2025-07-09 07:13:40', 0, '', '', '', '', '+94752446816', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10053, NULL, '', 1, 'Mr', 'Seba Hotel', 'Mr. Seba Hotel', '', '2025-07-09 07:14:30', 0, '', '', '', '', '+94754814843', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0001', '0', '', 0, 0, 1, 0, '-', 2),
(10054, NULL, '', 1, 'Mr', 'Test_Customer 1', 'Mr. Test_Customer 1', '', '2025-07-09 12:30:04', 0, 'rathnapura', '', '', '', '+94654544646', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0007', '0', '', 0, 0, 1, 0, '9787645315', 9),
(10055, NULL, '', 1, 'Mr', 'Test_Customer 2', 'Mr. Test_Customer 2', '', '2025-07-09 12:31:32', 0, 'Opanayaka ', '', '', '', '+94566464646', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-09', 0.00, 1, 1, '', '', 'EMP0007', '0', '', 0, 0, 1, 0, '789564233665', 9),
(10056, NULL, '', 1, 'Mr', 'cusabc', 'Mr. cusabc', '', '2025-07-16 01:57:45', 0, 'Opanayake', '', '', '', '+94546444546', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-16', 0.00, 1, 1, '', '', 'EMP0005', '0', '', 0, 0, 1, 0, '9787645315', 10),
(10057, NULL, '', 1, 'Mr', 'TEST SAMAN', 'Mr. TEST SAMAN', '', '2025-07-18 09:31:32', 0, 'RATHNAPUR', '', '', '', '+94546464646', '+94', '+94', '', '', 0, 0.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-18', 0.00, 2, 1, '', '', 'EMP0005', '0', '', 0, 0, 1, 0, '4564645454644', 10),
(10058, NULL, '', 1, 'Mr', 'TestAmal', 'Mr. TestAmal', '', '2025-07-21 11:53:46', 0, 'Opanayaka', '', '', '', '+94546546546', '+94', '+94', '', '', 0, 100.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-21', 0.00, 1, 1, '', '', 'EMP0004', '0', '', 0, 0, 1, 0, '4564645454644', 11),
(10059, NULL, '', 1, 'Mr', 'JAYAWARDHENA', 'Mr. JAYAWARDHENA', '', '2025-07-23 04:17:46', 0, 'RATNAPURA', '', '', '', '+94743214569', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-23', 0.00, 1, 1, '', '', 'EMP0009', '0', '', 0, 0, 1, 0, '123456789', 12),
(10060, NULL, '', 1, 'Mr', 'GUNADASA', 'Mr. GUNADASA', '', '2025-07-23 04:19:26', 0, '', '', '', '', '+94743214568', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-23', 0.00, 1, 1, '', '', 'EMP0009', '0', '', 0, 0, 1, 0, '9999999', 12),
(10061, NULL, '', 1, 'Mr', 'KAPUGE', 'Mr. KAPUGE', '', '2025-07-23 04:22:23', 0, 'AWISSAWELLA', '', '', '', '+94743214567', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-23', 0.00, 1, 1, '', '', 'EMP0009', '0', '', 0, 0, 1, 0, '9999999', 12),
(10062, NULL, '', 1, 'Mr', 'Customer_New', 'Mr. Customer_New', '', '2025-07-30 12:35:31', 0, 'Balangoda', '', '', '', '+94071956235', '+94435446546', '+94546464464', '', 'empnew@gmail.com', 0, 100.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-07-30', 0.00, 1, 1, '', '', 'EMP0010', '0', '', 0, 0, 1, 0, '2001759632555', 13),
(10063, NULL, '', 1, 'Mr', 'raveen', 'Mr. raveen', '', '2025-08-12 10:03:05', 0, 'test', '', '', '', '+94643564454', '+94', '+94', '', '', 0, 100.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-12', 0.00, 2, 1, '', '', 'EMP0006', '0', '', 0, 0, 1, 0, '9678520459', 8),
(10064, NULL, '', 1, 'Mr', 'YASHEN', 'Mr. YASHEN', '', '2025-08-28 12:36:39', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-28', 0.00, 1, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '111111111', 12),
(10065, NULL, '', 1, 'Mr', 'AKASH', 'Mr. AKASH', '', '2025-08-28 01:17:31', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-28', 0.00, 2, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '111111111', 1),
(10066, NULL, '', 1, 'Mr', 'GANESH', 'Mr. GANESH', '', '2025-08-28 01:18:43', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-28', 0.00, 1, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '111111111', 2),
(10067, NULL, '', 1, 'Mr', 'KAMAL', 'Mr. KAMAL', '', '2025-08-28 01:19:17', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-28', 0.00, 1, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '111111111', 3),
(10068, NULL, '', 1, 'Mr', 'JOHN', 'Mr. JOHN', '', '2025-08-28 01:19:54', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-28', 0.00, 1, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '199999998', 4),
(10069, NULL, '', 1, 'Mr', 'NAREN', 'Mr. NAREN', '', '2025-08-30 09:37:51', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-08-30', 0.00, 2, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '999999999', 12),
(10070, NULL, '', 1, 'Mr', 'DUSHEN', 'Mr. DUSHEN', '', '2025-09-01 09:20:12', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-09-01', 0.00, 2, 1, '', '', 'EMP0011', '0', '', 0, 0, 1, 1, '999999999', 12),
(10071, NULL, '', 1, 'Mr', 'MAHEN', 'Mr. MAHEN', '', '2025-09-01 12:58:46', 0, 'Paradise', '', '', '', '+94777777777', '+94', '+94', '', '', 0, 100000.00, 0, 0, '', NULL, NULL, '', '+94', 1, 0, '2025-09-01', 0.00, 2, 1, '', '', 'EMP0012', '0', '', 0, 0, 1, 1, '999999999', 12),
(10072, NULL, NULL, 1, 'Mr', 'Test', 'Test', '', '2025-09-02 17:38:21', 1, 'Trewq', '', '', NULL, '0000000000', '', '0000000000', '0000000000', 'none@none.com', 1, 0.00, 0, 0, 'NA', 0, '', '', '', 1, 0, NULL, 0.00, 2, 0, '', '', 'EMP0008', '', '', 0, 0, 0, 0, 'NA', 1),
(10073, NULL, NULL, 1, 'Mr', 'Indi', 'Indi', '', '2025-09-02 17:39:31', 1, 'Trf', '', '', NULL, '0000000000', '', '0000000000', '0000000000', 'none@none.com', 1, 0.00, 0, 0, 'NA', 0, '', '', '', 1, 0, NULL, 0.00, 2, 0, '', '', 'EMP0008', '', '', 0, 0, 0, 0, 'NA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customerorderdtl`
--

CREATE TABLE `customerorderdtl` (
  `PO_Id` int(11) NOT NULL,
  `AppNo` int(11) NOT NULL,
  `PO_No` varchar(8) NOT NULL,
  `ProductCode` varchar(18) NOT NULL,
  `PO_ProName` varchar(100) DEFAULT NULL,
  `PO_UPC` decimal(18,0) NOT NULL,
  `PO_Type` varchar(10) NOT NULL,
  `PO_UnitCost` decimal(18,2) NOT NULL,
  `PO_UnitPrice` decimal(10,2) DEFAULT 0.00,
  `PO_CaseCost` decimal(18,2) NOT NULL,
  `PO_DisPercentage` decimal(18,2) NOT NULL,
  `PO_DisAmount` decimal(18,2) NOT NULL,
  `PO_Qty` decimal(18,2) NOT NULL,
  `PO_TotalQty` decimal(18,2) NOT NULL,
  `GRN_Qty` decimal(18,2) NOT NULL,
  `PO_IsVat` tinyint(1) DEFAULT 0,
  `PO_IsNbt` tinyint(1) DEFAULT 0,
  `PO_NbtRatio` decimal(5,2) DEFAULT 0.00,
  `PO_VatAmount` decimal(18,2) DEFAULT NULL,
  `PO_NbtAmount` decimal(18,2) DEFAULT NULL,
  `PO_TotalAmount` decimal(18,2) NOT NULL,
  `PO_NetAmount` decimal(18,2) NOT NULL,
  `PO_LineNo` smallint(6) NOT NULL,
  `PO_IsComplete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customerorderhed`
--

CREATE TABLE `customerorderhed` (
  `AppNo` int(11) NOT NULL,
  `PO_No` varchar(8) NOT NULL,
  `QuotationNo` varchar(8) NOT NULL,
  `PO_Location` smallint(6) NOT NULL,
  `PO_Bil` varchar(20) DEFAULT NULL,
  `JobNo` varchar(10) DEFAULT NULL,
  `PO_Date` datetime NOT NULL,
  `PO_DeleveryDate` datetime NOT NULL,
  `SupCode` varchar(8) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `PO_IsNbtTotal` tinyint(1) DEFAULT 0,
  `PO_IsVatTotal` tinyint(1) DEFAULT 0,
  `PO_NbtRatioTotal` decimal(5,2) DEFAULT NULL,
  `PONbtAmount` decimal(18,2) DEFAULT NULL,
  `POVatAmount` decimal(18,2) DEFAULT NULL,
  `PO_TDisPercentage` decimal(18,2) NOT NULL,
  `PO_TDisAmount` decimal(18,2) NOT NULL,
  `PO_Amount` decimal(18,2) NOT NULL,
  `PO_NetAmount` decimal(18,2) NOT NULL,
  `PO_User` varchar(15) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsComplate` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customerorderpayment`
--

CREATE TABLE `customerorderpayment` (
  `Id` int(11) NOT NULL,
  `OrderNo` varchar(50) NOT NULL,
  `PayType` int(11) NOT NULL,
  `PayAmount` decimal(20,2) NOT NULL,
  `payDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customeroutstanding`
--

CREATE TABLE `customeroutstanding` (
  `CusCode` int(11) NOT NULL,
  `CusTotalInvAmount` decimal(18,2) NOT NULL,
  `CusOustandingAmount` decimal(18,2) NOT NULL,
  `CusSettlementAmount` decimal(18,2) NOT NULL,
  `OpenOustanding` decimal(18,2) NOT NULL,
  `OustandingDueAmount` decimal(18,2) NOT NULL,
  `old_cus` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customeroutstanding`
--

INSERT INTO `customeroutstanding` (`CusCode`, `CusTotalInvAmount`, `CusOustandingAmount`, `CusSettlementAmount`, `OpenOustanding`, `OustandingDueAmount`, `old_cus`) VALUES
(0, 0.00, -4502.00, 0.00, 0.00, 0.00, NULL),
(10001, 1706.40, 1684.40, 0.00, 0.00, 0.00, NULL),
(10002, 18707.00, 18616.00, 0.00, 0.00, 0.00, NULL),
(10003, 549.60, 549.60, 0.00, 0.00, 0.00, NULL),
(10004, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10005, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10006, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10007, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10008, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10009, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10010, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10011, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10012, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10013, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10014, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10015, 641.20, 41.20, 0.00, 0.00, 0.00, NULL),
(10016, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10017, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10018, 191060.84, 191060.84, 0.00, 0.00, 0.00, NULL),
(10019, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10020, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10021, 1300.00, 1300.00, 0.00, 0.00, 0.00, NULL),
(10022, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10023, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10024, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10025, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10026, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10027, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10028, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10029, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10030, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10031, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10032, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10033, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10034, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10035, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10036, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10037, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10038, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10039, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10040, 372.00, 372.00, 0.00, 0.00, 0.00, NULL),
(10041, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10042, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10043, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10044, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10045, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10046, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10047, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10048, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10049, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10050, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10051, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10052, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10053, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10054, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10055, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10056, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10057, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10058, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10059, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10060, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10061, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10062, 8719.89, 5001.50, 0.00, 0.00, 0.00, NULL),
(10063, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10064, 3712.05, 1900.00, 0.00, 0.00, 0.00, NULL),
(10065, 6680.80, 1180.80, 0.00, 0.00, 0.00, NULL),
(10066, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10067, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10068, 0.00, 0.00, 0.00, 0.00, 0.00, NULL),
(10069, 3973.75, 3973.75, -5154.80, 0.00, 0.00, NULL),
(10070, 450.00, 450.00, 0.00, 0.00, 0.00, NULL),
(10071, 26685.00, 19635.00, -7000.00, 0.00, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customerpaymentdtl`
--

CREATE TABLE `customerpaymentdtl` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `PaymentType` tinyint(1) DEFAULT 1,
  `CusPayNo` varchar(10) NOT NULL,
  `InvoiceNo` varchar(10) DEFAULT NULL,
  `PayDate` datetime NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `PayAmount` decimal(18,2) NOT NULL,
  `BankNo` smallint(6) NOT NULL,
  `ChequeNo` varchar(15) NOT NULL,
  `ChequeDate` datetime NOT NULL,
  `RecievedDate` datetime NOT NULL,
  `Reference` varchar(150) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `IsRelease` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customerpaymentdtl`
--

INSERT INTO `customerpaymentdtl` (`AppNo`, `Location`, `PaymentType`, `CusPayNo`, `InvoiceNo`, `PayDate`, `Mode`, `PayAmount`, `BankNo`, `ChequeNo`, `ChequeDate`, `RecievedDate`, `Reference`, `IsReturn`, `IsRelease`) VALUES
(1, 1, 1, 'CC0001', NULL, '2025-08-28 10:44:49', 'Cash', 1350.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0002', NULL, '2025-08-28 17:06:12', 'Cash', 600.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0003', NULL, '2025-08-30 12:11:08', 'Cash', 3974.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0004', NULL, '2025-08-30 12:11:54', 'Cash', 1180.80, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0005', NULL, '2025-08-30 12:51:49', 'Cash', 3980.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0006', NULL, '2025-08-30 12:55:30', 'Cash', 1000.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0007', NULL, '2025-08-30 13:25:44', 'Cash', 1380.05, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0008', NULL, '2025-08-30 14:47:44', 'Cash', 372.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0009', NULL, '2025-09-01 10:11:02', 'Cash', 500.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0010', NULL, '2025-09-01 14:48:36', 'Cash', 2000.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0011', NULL, '2025-09-01 14:50:34', 'Cash', 5000.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 1, 'CC0012', NULL, '2025-09-02 09:38:29', 'Cash', 3318.39, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customerpaymenthed`
--

CREATE TABLE `customerpaymenthed` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `PaymentType` tinyint(1) DEFAULT 1,
  `CusPayNo` varchar(8) NOT NULL,
  `PayDate` datetime NOT NULL,
  `RootNo` int(11) NOT NULL,
  `CusCode` varchar(10) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `CashPay` decimal(18,2) NOT NULL,
  `ChequePay` decimal(18,2) NOT NULL,
  `CardPay` decimal(18,2) NOT NULL,
  `TotalPayment` decimal(18,2) NOT NULL,
  `AvailableOustanding` decimal(18,2) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `CancelUser` varchar(15) NOT NULL,
  `SystemUser` varchar(15) NOT NULL,
  `SalesPerson` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customerpaymenthed`
--

INSERT INTO `customerpaymenthed` (`AppNo`, `Location`, `PaymentType`, `CusPayNo`, `PayDate`, `RootNo`, `CusCode`, `Remark`, `CashPay`, `ChequePay`, `CardPay`, `TotalPayment`, `AvailableOustanding`, `IsCancel`, `CancelUser`, `SystemUser`, `SalesPerson`) VALUES
(1, 1, 1, 'CC0001', '2025-08-28 10:44:49', 13, '0', '', 1350.00, 0.00, 0.00, 1350.00, 3318.39, 0, '0', '1', 'EMP0010'),
(1, 1, 1, 'CC0002', '2025-08-28 17:06:12', 1, '10015', '', 600.00, 0.00, 0.00, 600.00, 41.20, 0, '0', '1', 'EMP0001'),
(1, 1, 1, 'CC0003', '2025-08-30 12:11:08', 12, '10069', '', 3974.00, 0.00, 0.00, 3974.00, -0.25, 1, '1', '1', 'EMP0011'),
(1, 1, 1, 'CC0004', '2025-08-30 12:11:54', 12, '10069', '', 1180.80, 0.00, 0.00, 1180.80, 0.00, 1, '1', '1', 'EMP0011'),
(1, 1, 1, 'CC0005', '2025-08-30 12:51:49', 12, '0', '', 3980.00, 0.00, 0.00, 3980.00, -6.25, 0, '0', '1', 'EMP0011'),
(1, 1, 1, 'CC0006', '2025-08-30 12:55:30', 12, '0', '', 1000.00, 0.00, 0.00, 1000.00, 2280.05, 0, '0', '1', 'EMP0011'),
(1, 1, 1, 'CC0007', '2025-08-30 13:25:44', 12, '10064', '', 1380.05, 0.00, 0.00, 1380.05, 900.00, 0, '0', '1', 'EMP0011'),
(1, 1, 1, 'CC0008', '2025-08-30 14:47:44', 1, '0', '', 372.00, 0.00, 0.00, 372.00, 0.00, 0, '0', '1', 'EMP0001'),
(1, 1, 1, 'CC0009', '2025-09-01 10:11:02', 0, '0', '', 500.00, 0.00, 0.00, 500.00, -50.00, 0, '0', '1', ''),
(1, 1, 1, 'CC0010', '2025-09-01 14:48:36', 12, '10071', '', 2000.00, 0.00, 0.00, 2000.00, -50.00, 1, '1', '1', 'EMP0012'),
(1, 1, 1, 'CC0011', '2025-09-01 14:50:34', 12, '10071', '', 5000.00, 0.00, 0.00, 5000.00, -3050.00, 1, '1', '1', 'EMP0012'),
(1, 1, 1, 'CC0012', '2025-09-02 09:38:29', 13, '10062', '', 3318.39, 0.00, 0.00, 3318.39, 0.00, 0, '0', '1', 'EMP0010');

-- --------------------------------------------------------

--
-- Table structure for table `customer_account_type`
--

CREATE TABLE `customer_account_type` (
  `id` int(11) NOT NULL,
  `cus_acc_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_account_type`
--

INSERT INTO `customer_account_type` (`id`, `cus_acc_type`) VALUES
(1, 'Easy Customer'),
(2, 'Normal Customer');

-- --------------------------------------------------------

--
-- Table structure for table `customer_avc`
--

CREATE TABLE `customer_avc` (
  `cc` int(11) NOT NULL,
  `CusCode` bigint(20) NOT NULL,
  `RespectSign` varchar(10) NOT NULL,
  `CusNo` varchar(10) DEFAULT NULL,
  `CusName` varchar(100) NOT NULL,
  `Company_Name` varchar(100) DEFAULT NULL,
  `JoinDate` datetime NOT NULL,
  `RootNo` smallint(6) NOT NULL,
  `Address01` varchar(150) NOT NULL,
  `Address02` varchar(30) NOT NULL,
  `Address03` varchar(30) NOT NULL,
  `MobileNo` varchar(18) NOT NULL,
  `LanLineNo` varchar(18) NOT NULL,
  `Fax` varchar(18) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `IsAllowCredit` tinyint(4) NOT NULL,
  `CreditLimit` decimal(18,2) NOT NULL,
  `CreditPeriod` smallint(6) NOT NULL,
  `IsLoyalty` tinyint(4) NOT NULL,
  `LoyaltyNo` varchar(20) NOT NULL,
  `IsVat` tinyint(4) DEFAULT NULL,
  `VatNumber` varchar(30) DEFAULT NULL,
  `CusImage` longblob DEFAULT NULL,
  `CusImage2` longblob DEFAULT NULL,
  `IsActive` varchar(10) NOT NULL,
  `Flag` tinyint(4) NOT NULL,
  `BalanaceAmount` decimal(18,2) NOT NULL,
  `payMethod` tinyint(4) DEFAULT NULL,
  `CusType` tinyint(1) DEFAULT NULL,
  `CusCompany` tinyint(1) DEFAULT NULL,
  `DocNo` varchar(20) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `Category` varchar(20) DEFAULT NULL,
  `vehicle` varchar(100) DEFAULT NULL,
  `chassis` varchar(100) DEFAULT NULL,
  `HandelBy` varchar(20) DEFAULT NULL,
  `contactname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_category`
--

CREATE TABLE `customer_category` (
  `CusCatId` tinyint(4) NOT NULL,
  `CusCategory` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_category`
--

INSERT INTO `customer_category` (`CusCatId`, `CusCategory`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'NC'),
(6, 'NEW');

-- --------------------------------------------------------

--
-- Table structure for table `customer_routes`
--

CREATE TABLE `customer_routes` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_routes`
--

INSERT INTO `customer_routes` (`id`, `name`) VALUES
(1, 'AMPARA-1'),
(2, '	ERAGAMA'),
(3, 'CENTREL CAMP'),
(4, '	IGINIYAGALA'),
(5, '	WADINAGALA'),
(6, '	VELLAVELI'),
(7, '	WEERAGODA'),
(8, '	UHANA'),
(9, 'TEST_ROUTE'),
(10, 'TEST_ROUTE_1'),
(11, 'ROUTE1'),
(12, 'KURUWITA'),
(13, 'BALANGODA'),
(14, '2'),
(15, '1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `CusTypeId` tinyint(4) NOT NULL,
  `CusType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`CusTypeId`, `CusType`) VALUES
(1, 'General'),
(2, 'Company'),
(3, 'Insurance'),
(4, 'Warrnty');

-- --------------------------------------------------------

--
-- Table structure for table `customer_types`
--

CREATE TABLE `customer_types` (
  `CusTypeId` tinyint(4) NOT NULL DEFAULT 0,
  `CusType` varchar(20) DEFAULT NULL,
  `CusTypeRemark` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_types`
--

INSERT INTO `customer_types` (`CusTypeId`, `CusType`, `CusTypeRemark`) VALUES
(1, 'Customer', NULL),
(2, 'Guarantee', NULL),
(3, 'Other', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cus_document`
--

CREATE TABLE `cus_document` (
  `doc_id` int(11) NOT NULL,
  `job_no` varchar(10) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `upload_by` tinyint(4) DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cus_over_payment_dtl`
--

CREATE TABLE `cus_over_payment_dtl` (
  `PaymentId` varchar(20) NOT NULL,
  `PaymentType` int(11) NOT NULL DEFAULT 0,
  `PayAmount` decimal(20,2) DEFAULT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `DepCode` smallint(6) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`DepCode`, `Description`, `Flag`) VALUES
(1, '200 ML', NULL),
(2, '400 ML', NULL),
(3, '2000 ML', NULL),
(4, '250 ML', NULL),
(5, '300 ML', NULL),
(6, '400 ML', NULL),
(7, '750 ML', NULL),
(8, '1000 ML', NULL),
(9, '1500 ML', NULL),
(10, '500 ML', NULL),
(11, 'Dep1', NULL),
(12, 'Dep 2', NULL),
(13, 'D1', NULL),
(14, '', NULL),
(15, 'D3', NULL),
(16, '1L', NULL),
(17, 'Dep_New', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `down_paid`
--

CREATE TABLE `down_paid` (
  `PaymentId` varchar(20) NOT NULL,
  `PaymentType` int(11) NOT NULL DEFAULT 0,
  `TotalPayment` decimal(20,2) DEFAULT NULL,
  `CashPayment` decimal(20,2) DEFAULT NULL,
  `ChequePayment` decimal(20,2) DEFAULT NULL,
  `PayAmount` decimal(20,2) DEFAULT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `AccNo` varchar(20) DEFAULT NULL,
  `CusCode` varchar(10) DEFAULT NULL,
  `PayDate` date DEFAULT NULL,
  `ChequeNo` varchar(50) DEFAULT NULL,
  `ChequeRecDate` date DEFAULT NULL,
  `ChequeDate` date DEFAULT NULL,
  `ChequeReference` varchar(100) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `InsuranceAmount` decimal(20,2) DEFAULT NULL,
  `InvDate` datetime DEFAULT NULL,
  `IsCancel` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `down_paid_dtl`
--

CREATE TABLE `down_paid_dtl` (
  `PaymentId` varchar(20) NOT NULL,
  `PaymentType` int(11) NOT NULL DEFAULT 0,
  `PayAmount` decimal(20,2) DEFAULT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `AccNo` varchar(20) DEFAULT NULL,
  `Month` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `down_payment_dtl`
--

CREATE TABLE `down_payment_dtl` (
  `InvNo` varchar(10) NOT NULL DEFAULT '',
  `DwPayType` int(11) NOT NULL DEFAULT 0,
  `DownPayment` decimal(20,2) DEFAULT NULL,
  `Interest` int(11) DEFAULT NULL,
  `InterestAmount` decimal(20,2) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `IsInterest` tinyint(1) DEFAULT NULL,
  `RentalDefault` decimal(20,2) DEFAULT 0.00,
  `WRentalDefault` decimal(20,2) DEFAULT 0.00,
  `TotalDue` decimal(20,2) DEFAULT 0.00,
  `SettleAmount` decimal(20,2) DEFAULT NULL,
  `IsPaid` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editinvoices`
--

CREATE TABLE `editinvoices` (
  `Editid` int(11) NOT NULL,
  `AppNo` int(11) NOT NULL,
  `EditType` tinyint(1) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `UpdateDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `Remark` varchar(250) NOT NULL,
  `UpdateUser` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `editinvoices`
--

INSERT INTO `editinvoices` (`Editid`, `AppNo`, `EditType`, `Location`, `UpdateDate`, `InvoiceNo`, `Remark`, `UpdateUser`) VALUES
(4, 1, 1, 1, '2025-08-12 13:12:27', 'WI0001', 'Created', '1'),
(5, 1, 1, 1, '2025-08-12 13:16:28', 'AEC0001', 'Created', '1'),
(6, 1, 1, 1, '2025-08-12 13:23:25', 'AEC0002', 'Created', '1'),
(7, 1, 1, 1, '2025-08-12 13:36:19', 'AEC0003', 'Created', '1'),
(8, 1, 1, 1, '2025-08-12 13:37:41', 'WI0002', 'Created', '1'),
(9, 1, 1, 1, '2025-08-12 14:23:30', 'AEC0004', 'Created', '1'),
(10, 1, 1, 1, '2025-08-12 15:00:36', 'WI0003', 'Created', '1'),
(11, 1, 1, 1, '2025-08-12 15:04:28', 'AEC0005', 'Created', '1'),
(12, 1, 1, 1, '2025-08-13 11:42:03', 'WI0004', 'Created', '1'),
(13, 1, 1, 1, '2025-08-13 11:42:41', 'WI0005', 'Created', '1'),
(14, 1, 1, 1, '2025-08-13 11:46:09', 'WI0006', 'Created', '1'),
(15, 1, 1, 1, '2025-08-13 12:26:02', 'WI0007', 'Created', '1'),
(16, 1, 1, 1, '2025-08-13 12:28:15', 'AEC0006', 'Created', '1'),
(17, 1, 1, 1, '2025-08-13 12:29:23', 'AEC0007', 'Created', '1'),
(18, 1, 1, 1, '2025-08-13 12:32:22', 'AEC0008', 'Created', '1'),
(19, 1, 1, 1, '2025-08-13 12:41:56', 'WI0008', 'Created', '1'),
(20, 1, 1, 1, '2025-08-13 12:43:21', 'WI0009', 'Created', '1'),
(21, 1, 1, 1, '2025-08-13 13:07:53', 'WI0010', 'Created', '1'),
(22, 1, 1, 1, '2025-08-13 13:12:11', 'WI0011', 'Created', '1'),
(23, 1, 1, 1, '2025-08-13 13:15:08', 'WI0012', 'Created', '1'),
(24, 1, 1, 1, '2025-08-13 13:16:57', 'WI0013', 'Created', '1'),
(25, 1, 1, 1, '2025-08-13 13:21:36', 'WI0014', 'Created', '1'),
(26, 1, 1, 1, '2025-08-13 13:30:35', 'WI0015', 'Created', '1'),
(27, 1, 1, 1, '2025-08-13 13:43:35', 'AEC0009', 'Created', '1'),
(28, 1, 1, 1, '2025-08-21 10:16:18', 'WI0016', 'Created', '1'),
(29, 1, 1, 1, '2025-08-21 14:05:59', 'AEC0010', 'Created', '1'),
(30, 1, 1, 1, '2025-08-21 14:57:33', 'AEC0011', 'Created', '1'),
(31, 1, 1, 1, '2025-08-21 15:02:55', 'AEC0012', 'Created', '1'),
(32, 1, 1, 1, '2025-08-26 14:03:01', 'AEC0013', 'Created', '1'),
(33, 1, 1, 1, '2025-08-26 14:19:51', 'AEC0014', 'Created', '1'),
(34, 1, 1, 1, '2025-08-27 14:00:34', 'AEC0015', 'Created', '1'),
(35, 1, 1, 1, '2025-08-27 15:49:57', 'AEC0016', 'Created', '1'),
(36, 1, 9, 1, '2025-08-28 10:48:39', 'CC0001', 'Created', '1'),
(37, 1, 1, 1, '2025-08-28 12:51:03', 'AEC0017', 'Created', '1'),
(38, 1, 1, 1, '2025-08-28 13:02:25', 'AEC0018', 'Created', '1'),
(39, 1, 1, 1, '2025-08-28 16:28:42', 'WI0017', 'Created', '1'),
(40, 1, 1, 1, '2025-08-28 17:05:22', 'AEC0019', 'Created', '1'),
(41, 1, 9, 1, '2025-08-28 17:06:29', 'CC0002', 'Created', '1'),
(42, 1, 1, 1, '2025-08-29 15:23:24', 'AEC0020', 'Created', '1'),
(43, 1, 1, 1, '2025-08-30 09:22:06', 'AEC0021', 'Created', '1'),
(44, 1, 1, 1, '2025-08-30 09:38:36', 'AEC0022', 'Created', '1'),
(45, 1, 1, 1, '2025-08-30 09:50:02', 'AEC0023', 'Created', '1'),
(46, 1, 9, 1, '2025-08-30 12:11:51', 'CC0003', 'Created', '1'),
(47, 1, 9, 1, '2025-08-30 12:12:53', 'CC0004', 'Created', '1'),
(48, 1, 1, 1, '2025-08-30 12:43:01', 'AEC0024', 'Created', '1'),
(49, 1, 9, 1, '2025-08-30 12:52:43', 'CC0005', 'Created', '1'),
(50, 1, 9, 1, '2025-08-30 12:55:55', 'CC0006', 'Created', '1'),
(51, 1, 9, 1, '2025-08-30 13:26:01', 'CC0007', 'Created', '1'),
(52, 1, 1, 1, '2025-08-30 14:19:50', 'AEC0025', 'Created', '1'),
(53, 1, 1, 1, '2025-08-30 14:35:48', 'AEC0026', 'Created', '1'),
(54, 1, 9, 1, '2025-08-30 14:48:42', 'CC0008', 'Created', '1'),
(55, 1, 11, 1, '2025-08-30 15:01:50', '0', 'Created', '1'),
(56, 1, 1, 1, '2025-09-01 09:54:16', 'AEC0027', 'Created', '1'),
(57, 1, 9, 1, '2025-09-01 10:13:58', 'CC0009', 'Created', '1'),
(58, 1, 1, 1, '2025-09-01 13:56:09', 'AEC0028', 'Created', '1'),
(59, 1, 9, 1, '2025-09-01 14:49:02', 'CC0010', 'Created', '1'),
(60, 1, 9, 1, '2025-09-01 14:50:59', 'CC0011', 'Created', '1'),
(61, 1, 1, 1, '2025-09-01 14:59:18', 'AEC0029', 'Created', '1'),
(62, 1, 1, 1, '2025-09-01 15:15:44', 'AEC0029', 'Updated', '1'),
(64, 1, 1, 1, '2025-09-01 15:21:17', 'AEC0028', 'Updated', '1'),
(66, 1, 9, 1, '2025-09-02 09:39:22', 'CC0012', 'Created', '1'),
(67, 1, 1, 1, '2025-09-02 09:53:01', 'AEC0030', 'Created', '1'),
(68, 1, 1, 1, '2025-09-02 10:39:35', 'AEC0031', 'Created', '1'),
(69, 1, 12, 1, '2025-09-02 10:53:05', 'SPM0001', 'Created', '1'),
(70, 1, 12, 1, '2025-09-02 10:54:20', 'SPM0001', 'Created', '1'),
(71, 1, 12, 1, '2025-09-02 10:55:00', 'SPM0001', 'Created', '1'),
(72, 1, 11, 1, '2025-09-02 11:18:31', '0', 'Created', '1'),
(73, 1, 12, 1, '2025-09-02 13:02:08', 'SPM0001', 'Created', '1'),
(74, 1, 12, 1, '2025-09-02 15:01:42', 'SPM0001', 'Created', '1'),
(75, 1, 12, 1, '2025-09-02 15:02:47', 'SPM0002', 'Created', '1'),
(76, 1, 1, 1, '2025-09-02 15:14:34', 'AEC0032', 'Created', '1'),
(77, 1, 1, 1, '2025-09-02 15:19:53', 'AEC0033', 'Created', '1'),
(78, 1, 1, 1, '2025-09-02 15:43:44', 'AEC0034', 'Created', '1'),
(79, 1, 1, 1, '2025-09-02 15:58:10', 'AEC0035', 'Created', '1'),
(80, 1, 1, 1, '2025-09-02 15:58:24', 'AEC0036', 'Created', '1'),
(81, 1, 1, 1, '2025-09-02 16:00:16', 'AEC0037', 'Created', '1'),
(82, 1, 1, 1, '2025-09-02 16:02:11', 'AEC0038', 'Created', '1'),
(83, 1, 12, 1, '2025-09-02 16:12:02', 'SPM0003', 'Created', '1'),
(84, 1, 1, 1, '2025-09-02 16:15:55', 'AEC0039', 'Created', '1'),
(85, 1, 1, 1, '2025-09-02 16:16:59', 'AEC0040', 'Created', '1'),
(86, 1, 1, 1, '2025-09-03 12:19:29', 'AEC0041', 'Created', '1'),
(87, 1, 1, 1, '2025-09-03 12:59:21', 'AEC0042', 'Created', '1');

-- --------------------------------------------------------

--
-- Table structure for table `employeeroutes`
--

CREATE TABLE `employeeroutes` (
  `id` int(11) NOT NULL,
  `emp_id` varchar(100) NOT NULL,
  `route_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employeeroutes`
--

INSERT INTO `employeeroutes` (`id`, `emp_id`, `route_id`) VALUES
(36, 'EMP0001', 1),
(37, 'EMP0001', 2),
(39, 'EMP0008', 1),
(40, 'EMP0008', 2),
(41, 'EMP0008', 3),
(42, 'EMP0008', 4),
(43, 'EMP0002', 5),
(44, 'EMP0002', 6),
(45, 'EMP0003', 5),
(46, 'EMP0003', 1),
(47, 'EMP0006', 8),
(49, 'EMP0001', 3),
(50, 'EMP0001', 4),
(51, 'EMP0001', 5),
(52, 'EMP0001', 6),
(53, 'EMP0001', 7),
(54, 'EMP0001', 8),
(55, 'EMP0002', 1),
(56, 'EMP0002', 2),
(57, 'EMP0002', 3),
(58, 'EMP0002', 4),
(59, 'EMP0002', 7),
(60, 'EMP0002', 8),
(61, 'EMP0003', 2),
(62, 'EMP0003', 3),
(63, 'EMP0003', 4),
(64, 'EMP0003', 6),
(65, 'EMP0003', 7),
(66, 'EMP0003', 8),
(68, 'EMP0007', 9),
(69, 'EMP0006', 9),
(70, 'EMP0005', 10),
(71, 'EMP0004', 11),
(72, 'EMP0009', 12),
(73, 'EMP0010', 13),
(74, 'EMP0011', 12),
(75, 'EMP0011', 1),
(76, 'EMP0011', 2),
(77, 'EMP0011', 3),
(78, 'EMP0011', 4),
(79, 'EMP0012', 1),
(80, 'EMP0012', 12),
(81, 'EMP0012', 2),
(82, 'EMP0012', 3);

-- --------------------------------------------------------

--
-- Table structure for table `emp_type`
--

CREATE TABLE `emp_type` (
  `EmpTypeNo` int(11) NOT NULL,
  `EmpType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `emp_type`
--

INSERT INTO `emp_type` (`EmpTypeNo`, `EmpType`) VALUES
(1, 'Stock Keeper'),
(2, 'Director'),
(3, 'Accountant'),
(4, 'Service Advisor'),
(5, 'HRM'),
(6, 'Sales Executive');

-- --------------------------------------------------------

--
-- Table structure for table `estimatedtl`
--

CREATE TABLE `estimatedtl` (
  `estimatedtlid` int(11) NOT NULL,
  `EstimateNo` varchar(10) NOT NULL,
  `SupplimentryNo` varchar(10) DEFAULT '0',
  `EstJobCardNo` varchar(10) NOT NULL,
  `EstJobOrder` tinyint(1) DEFAULT NULL,
  `EstJobType` varchar(255) DEFAULT NULL,
  `EstJobId` int(11) DEFAULT NULL,
  `EstJobDescription` varchar(255) DEFAULT NULL,
  `EstQty` int(11) DEFAULT NULL,
  `EstCost` decimal(10,2) DEFAULT NULL,
  `EstPrice` decimal(10,2) DEFAULT NULL,
  `EstIsInsurance` tinyint(1) DEFAULT 0,
  `EstInsurance` varchar(30) DEFAULT NULL,
  `EstTotalAmount` decimal(10,2) DEFAULT NULL,
  `EstDiscount` decimal(10,2) DEFAULT NULL,
  `EstIsVat` tinyint(1) DEFAULT 0,
  `EstIsNbt` tinyint(1) DEFAULT 0,
  `EstNbtRatio` decimal(5,2) DEFAULT 1.00,
  `EstVatAmount` decimal(20,2) DEFAULT 0.00,
  `EstNbtAmount` decimal(20,2) DEFAULT 0.00,
  `EstNetAmount` decimal(10,2) DEFAULT NULL,
  `EstPartType` varchar(5) DEFAULT NULL,
  `EstDiscountType` tinyint(4) DEFAULT NULL,
  `EstinvoiceTimestamp` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimatehed`
--

CREATE TABLE `estimatehed` (
  `JobInvNo` varchar(10) NOT NULL DEFAULT '',
  `EstimateNo` varchar(10) NOT NULL DEFAULT '',
  `Supplimentry` varchar(10) NOT NULL DEFAULT '',
  `EstJobCardNo` varchar(10) NOT NULL DEFAULT '',
  `EstCompanyCode` varchar(10) NOT NULL,
  `EstLocation` tinyint(1) DEFAULT 1,
  `EstInsCompany` int(11) DEFAULT NULL,
  `EstCustomer` varchar(10) DEFAULT NULL,
  `EstRegNo` varchar(15) DEFAULT NULL,
  `EstimateAmount` decimal(18,2) DEFAULT NULL,
  `EstIsNbtTotal` tinyint(1) DEFAULT 0,
  `EstIsVatTotal` tinyint(1) DEFAULT 0,
  `EstNbtRatioTotal` decimal(5,2) DEFAULT 1.00,
  `EstNbtAmount` decimal(20,2) DEFAULT 0.00,
  `EstVatAmount` decimal(20,2) DEFAULT 0.00,
  `EstNetAmount` decimal(20,2) DEFAULT 0.00,
  `EstDate` datetime NOT NULL,
  `EstType` varchar(10) NOT NULL,
  `EstJobType` int(11) NOT NULL,
  `IsCompelte` tinyint(1) NOT NULL,
  `IsCancel` tinyint(1) NOT NULL,
  `IsEdit` tinyint(1) DEFAULT NULL,
  `EstLastNo` tinyint(4) DEFAULT 0,
  `EstUser` tinyint(4) DEFAULT NULL,
  `IsSup` tinyint(1) DEFAULT 0,
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `estimate_jobtype`
--

CREATE TABLE `estimate_jobtype` (
  `EstimateJobNo` int(11) NOT NULL,
  `EstimateJobType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `estimate_jobtype`
--

INSERT INTO `estimate_jobtype` (`EstimateJobNo`, `EstimateJobType`) VALUES
(1, 'Insurance'),
(2, 'General'),
(3, '');

-- --------------------------------------------------------

--
-- Table structure for table `estimate_type`
--

CREATE TABLE `estimate_type` (
  `EstimateTypeNo` int(11) NOT NULL,
  `EstimateType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `estimate_type`
--

INSERT INTO `estimate_type` (`EstimateTypeNo`, `EstimateType`) VALUES
(1, 'General '),
(2, 'Supplimentery');

-- --------------------------------------------------------

--
-- Table structure for table `estimate_worktype`
--

CREATE TABLE `estimate_worktype` (
  `estimate_type_id` int(11) NOT NULL,
  `estimate_type_code` varchar(10) DEFAULT NULL,
  `estimate_type_name` varchar(100) DEFAULT NULL,
  `estimate_type_order` tinyint(4) DEFAULT NULL,
  `estimate_type_comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `estimate_worktype`
--

INSERT INTO `estimate_worktype` (`estimate_type_id`, `estimate_type_code`, `estimate_type_name`, `estimate_type_order`, `estimate_type_comment`) VALUES
(1, 'L001', 'Labour', 1, '1'),
(2, 'S002', 'Parts', 3, NULL),
(3, 'P001', 'Paints', 4, NULL),
(4, 'S003', 'Parts 3', 5, NULL),
(5, 'S001', 'Parts Outside', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `est_document`
--

CREATE TABLE `est_document` (
  `doc_id` int(11) NOT NULL,
  `est_no` varchar(10) NOT NULL,
  `doc_name` varchar(100) NOT NULL,
  `upload_by` tinyint(4) NOT NULL,
  `upload_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel_type`
--

CREATE TABLE `fuel_type` (
  `fuel_typeid` int(11) NOT NULL,
  `fuel_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `fuel_type`
--

INSERT INTO `fuel_type` (`fuel_typeid`, `fuel_type`) VALUES
(1, 'Disel'),
(2, 'Petral');

-- --------------------------------------------------------

--
-- Table structure for table `goodsreceivenotedtl`
--

CREATE TABLE `goodsreceivenotedtl` (
  `AppNo` int(11) NOT NULL,
  `GRN_No` varchar(8) NOT NULL,
  `GRN_Date` datetime NOT NULL,
  `GRN_PONo` varchar(8) NOT NULL,
  `GRN_Product` varchar(18) NOT NULL,
  `GRN_UPC` decimal(18,0) NOT NULL,
  `GRN_UPCType` varchar(6) NOT NULL,
  `GRN_Qty` decimal(18,2) NOT NULL,
  `GRN_TotalQty` decimal(18,2) DEFAULT NULL,
  `GRN_FreeQty` decimal(18,2) NOT NULL,
  `GRN_OrderQty` decimal(18,2) NOT NULL,
  `GRN_BalanceQty` decimal(18,2) NOT NULL,
  `GRN_ReturnQty` decimal(18,2) NOT NULL,
  `GRN_IsVat` tinyint(1) DEFAULT 0,
  `GRN_IsNbt` tinyint(1) DEFAULT 0,
  `GRN_NbtRatio` decimal(5,2) DEFAULT 1.00,
  `GRN_CaseCost` decimal(18,2) DEFAULT NULL,
  `GRN_UnitCost` decimal(18,2) NOT NULL,
  `GRN_QtyPrice` decimal(18,2) DEFAULT NULL,
  `GRN_PriceLevel` smallint(6) NOT NULL,
  `GRN_Selling` decimal(18,2) NOT NULL,
  `GRN_VatAmount` decimal(10,2) DEFAULT 0.00,
  `GRN_NbtAmount` decimal(10,2) DEFAULT 0.00,
  `GRN_DisAmount` decimal(18,2) NOT NULL,
  `GRN_DisPersantage` decimal(18,2) NOT NULL,
  `GRN_Amount` decimal(18,2) NOT NULL,
  `GRN_NetAmount` decimal(18,2) NOT NULL,
  `GRN_LineNo` int(11) NOT NULL,
  `IsSerial` tinyint(4) NOT NULL,
  `SerialNo` varchar(20) NOT NULL,
  `CostCode` decimal(18,2) DEFAULT NULL,
  `WholeSalesPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `goodsreceivenotedtl`
--

INSERT INTO `goodsreceivenotedtl` (`AppNo`, `GRN_No`, `GRN_Date`, `GRN_PONo`, `GRN_Product`, `GRN_UPC`, `GRN_UPCType`, `GRN_Qty`, `GRN_TotalQty`, `GRN_FreeQty`, `GRN_OrderQty`, `GRN_BalanceQty`, `GRN_ReturnQty`, `GRN_IsVat`, `GRN_IsNbt`, `GRN_NbtRatio`, `GRN_CaseCost`, `GRN_UnitCost`, `GRN_QtyPrice`, `GRN_PriceLevel`, `GRN_Selling`, `GRN_VatAmount`, `GRN_NbtAmount`, `GRN_DisAmount`, `GRN_DisPersantage`, `GRN_Amount`, `GRN_NetAmount`, `GRN_LineNo`, `IsSerial`, `SerialNo`, `CostCode`, `WholeSalesPrice`) VALUES
(1, 'GRN0001', '2025-08-11 00:00:00', '', '100007', 24, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 1042.90, 1042.90, 0, 0, '', 111.46, 0.00),
(1, 'GRN0002', '2025-08-11 00:00:00', '', '100010', 24, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 1042.90, 1042.90, 0, 0, '', 111.46, 0.00),
(1, 'GRN0003', '2025-08-12 00:00:00', '', '100047', 12, 'UNIT', 100.00, 100.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 100.00, 100.00, 1, 130.00, 0.00, 0.00, 0.00, 0.00, 10000.00, 10000.00, 0, 0, '', 130.00, 0.00),
(1, 'GRN0004', '2025-08-13 00:00:00', '', '100002', 12, 'UNIT', 1.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 250.00, 250.00, 1, 282.00, 0.00, 0.00, 0.00, 0.00, 250.00, 250.00, 0, 0, '', 282.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100001', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 350.50, 350.50, 1, 372.00, 0.00, 0.00, 0.00, 0.00, 350500.00, 350500.00, 0, 0, '', 372.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100002', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 250.00, 250.00, 1, 282.00, 0.00, 0.00, 0.00, 0.00, 250000.00, 250000.00, 1, 0, '', 282.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100004', 9, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 423.00, 423.00, 1, 448.56, 0.00, 0.00, 0.00, 0.00, 423000.00, 423000.00, 2, 0, '', 448.56, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100005', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 155.54, 155.54, 1, 187.25, 0.00, 0.00, 0.00, 0.00, 155540.00, 155540.00, 3, 0, '', 187.25, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100007', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 104290.00, 104290.00, 4, 0, '', 111.46, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100008', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 5, 0, '', 91.60, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100009', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 6, 0, '', 91.60, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100010', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 104290.00, 104290.00, 7, 0, '', 111.46, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100012', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 155.54, 155.54, 1, 187.25, 0.00, 0.00, 0.00, 0.00, 155540.00, 155540.00, 8, 0, '', 187.25, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100014', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 263.50, 263.50, 1, 282.00, 0.00, 0.00, 0.00, 0.00, 263500.00, 263500.00, 9, 0, '', 282.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100015', 10, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 350.50, 350.50, 1, 372.00, 0.00, 0.00, 0.00, 0.00, 350500.00, 350500.00, 10, 0, '', 372.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100016', 9, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 422.78, 422.78, 1, 448.56, 0.00, 0.00, 0.00, 0.00, 422780.00, 422780.00, 11, 0, '', 448.56, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100017', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 12, 0, '', 91.60, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100018', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 104290.00, 104290.00, 13, 0, '', 111.46, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100020', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 155.54, 155.54, 1, 165.63, 0.00, 0.00, 0.00, 0.00, 155540.00, 155540.00, 14, 0, '', 165.63, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100022', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 263.50, 263.50, 1, 282.00, 0.00, 0.00, 0.00, 0.00, 263500.00, 263500.00, 15, 0, '', 282.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100023', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 350.50, 350.50, 1, 372.00, 0.00, 0.00, 0.00, 0.00, 350500.00, 350500.00, 16, 0, '', 372.00, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100024', 9, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 422.78, 422.78, 1, 448.56, 0.00, 0.00, 0.00, 0.00, 422780.00, 422780.00, 17, 0, '', 448.56, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100025', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 18, 0, '', 91.60, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100026', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 104.29, 104.29, 1, 111.46, 0.00, 0.00, 0.00, 0.00, 104290.00, 104290.00, 19, 0, '', 111.46, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100027', 24, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 155.54, 155.54, 1, 187.25, 0.00, 0.00, 0.00, 0.00, 155540.00, 155540.00, 20, 0, '', 187.25, 0.00),
(1, 'GRN0005', '2025-08-13 00:00:00', '', '100029', 12, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 350.50, 350.50, 1, 372.00, 0.00, 0.00, 0.00, 0.00, 350500.00, 350500.00, 21, 0, '', 372.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100048', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 0, 0, '', 91.60, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100049', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 87.00, 87.00, 1, 92.88, 0.00, 0.00, 0.00, 0.00, 87000.00, 87000.00, 1, 0, '', 92.88, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100050', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 130.00, 130.00, 1, 138.00, 0.00, 0.00, 0.00, 0.00, 130000.00, 130000.00, 2, 0, '', 138.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100051', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 252.50, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 3, 0, '', 252.50, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100052', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 341.00, 341.00, 1, 361.00, 0.00, 0.00, 0.00, 0.00, 341000.00, 341000.00, 4, 0, '', 361.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100053', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 5, 0, '', 91.60, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100054', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 87.00, 87.00, 1, 92.88, 0.00, 0.00, 0.00, 0.00, 87000.00, 87000.00, 6, 0, '', 92.88, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100055', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 130.00, 130.00, 1, 138.00, 0.00, 0.00, 0.00, 0.00, 130000.00, 130000.00, 7, 0, '', 138.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100056', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 252.50, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 8, 0, '', 252.50, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100057', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 85000.00, 85000.00, 9, 0, '', 91.60, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100058', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 87.00, 87.00, 1, 92.88, 0.00, 0.00, 0.00, 0.00, 87000.00, 87000.00, 10, 0, '', 92.88, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100059', 1, 'UNIT', 1100.00, 1100.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 130.00, 130.00, 1, 138.00, 0.00, 0.00, 0.00, 0.00, 143000.00, 143000.00, 11, 0, '', 138.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100060', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 252.50, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 12, 0, '', 252.50, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100061', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 87.00, 87.00, 1, 92.00, 0.00, 0.00, 0.00, 0.00, 87000.00, 87000.00, 13, 0, '', 92.00, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100062', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 147.00, 147.00, 1, 156.45, 0.00, 0.00, 0.00, 0.00, 147000.00, 147000.00, 14, 0, '', 156.45, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100063', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 56.00, 56.00, 1, 60.50, 0.00, 0.00, 0.00, 0.00, 56000.00, 56000.00, 15, 0, '', 60.50, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100064', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 80.00, 80.00, 1, 86.67, 0.00, 0.00, 0.00, 0.00, 80000.00, 80000.00, 16, 0, '', 86.67, 0.00),
(1, 'GRN0006', '2025-08-13 00:00:00', '', '100065', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 103.00, 103.00, 1, 113.33, 0.00, 0.00, 0.00, 0.00, 103000.00, 103000.00, 17, 0, '', 113.33, 0.00),
(1, 'GRN0007', '2025-08-13 00:00:00', '', '100051', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 253.75, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 0, 0, '', 253.75, 0.00),
(1, 'GRN0007', '2025-08-13 00:00:00', '', '100056', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 253.75, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 2, 0, '', 253.75, 0.00),
(1, 'GRN0007', '2025-08-13 00:00:00', '', '100060', 1, 'UNIT', 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 236.00, 236.00, 1, 253.75, 0.00, 0.00, 0.00, 0.00, 236000.00, 236000.00, 1, 0, '', 253.75, 0.00),
(1, 'GRN0008', '2025-08-13 00:00:00', '', '100020', 24, 'UNIT', 1.00, 1.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 155.54, 155.54, 1, 165.00, 0.00, 0.00, 0.00, 0.00, 155.54, 155.54, 0, 0, '', 165.00, 0.00),
(1, 'GRN0009', '2025-08-21 00:00:00', '', '100068', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0010', '2025-08-21 00:00:00', '', '100068', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 150.00, 0.00, 0.00, 0.00, 0.00, 700.00, 700.00, 0, 0, '', 150.00, 0.00),
(1, 'GRN0011', '2025-08-21 00:00:00', '', '100069', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 200.00, 0.00, 0.00, 0.00, 0.00, 700.00, 700.00, 0, 0, '', 200.00, 0.00),
(1, 'GRN0012', '2025-08-21 00:00:00', '', '100069', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 100.00, 100.00, 1, 300.00, 0.00, 0.00, 0.00, 0.00, 1000.00, 1000.00, 0, 0, '', 300.00, 0.00),
(1, 'GRN0013', '2025-08-26 00:00:00', '', '100008', 24, 'UNIT', 600.00, 600.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 85.00, 85.00, 1, 91.60, 0.00, 0.00, 0.00, 0.00, 51000.00, 51000.00, 0, 0, '', 91.60, 0.00),
(1, 'GRN0014', '2025-08-28 00:00:00', '', '100070', 5, 'UNIT', 40.00, 50.00, 10.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 2000.00, 2000.00, 0, 0, '', 100.00, 80.00),
(1, 'GRN0015', '2025-08-28 00:00:00', '', '100070', 5, 'UNIT', 20.00, 22.00, 2.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 60.00, 60.00, 1, 120.00, 0.00, 0.00, 0.00, 0.00, 1200.00, 1200.00, 0, 0, '', 120.00, 90.00),
(1, 'GRN0016', '2025-08-30 00:00:00', '', '100071', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0017', '2025-08-30 00:00:00', '', '100071', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 60.00, 60.00, 1, 120.00, 0.00, 0.00, 0.00, 0.00, 600.00, 600.00, 0, 0, '', 120.00, 0.00),
(1, 'GRN0018', '2025-08-30 00:00:00', '', '100072', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 2, 0, '', 100.00, 0.00),
(1, 'GRN0018', '2025-08-30 00:00:00', '', '100073', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 100.00, 100.00, 1, 200.00, 0.00, 0.00, 0.00, 0.00, 1000.00, 1000.00, 1, 0, '', 200.00, 0.00),
(1, 'GRN0018', '2025-08-30 00:00:00', '', '100074', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 100.00, 100.00, 1, 250.00, 0.00, 0.00, 0.00, 0.00, 1000.00, 1000.00, 0, 0, '', 250.00, 0.00),
(1, 'GRN0019', '2025-08-30 00:00:00', '', '100072', 1, 'UNIT', 5.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 80.00, 80.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 400.00, 400.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0020', '2025-08-30 00:00:00', '', '100072', 1, 'UNIT', 5.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 350.00, 350.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0021', '2025-08-30 00:00:00', '', '100072', 1, 'UNIT', 5.00, 5.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 80.00, 80.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 400.00, 400.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0022', '2025-08-30 00:00:00', '', '100072', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 60.00, 60.00, 1, 120.00, 0.00, 0.00, 0.00, 0.00, 600.00, 600.00, 0, 0, '', 120.00, 0.00),
(1, 'GRN0023', '2025-09-01 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0023', '2025-09-01 00:00:00', '', '100076', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 100.00, 100.00, 1, 200.00, 0.00, 0.00, 0.00, 0.00, 1000.00, 1000.00, 1, 0, '', 200.00, 0.00),
(1, 'GRN0023', '2025-09-01 00:00:00', '', '100077', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 150.00, 150.00, 1, 250.00, 0.00, 0.00, 0.00, 0.00, 1500.00, 1500.00, 2, 0, '', 250.00, 0.00),
(1, 'GRN0024', '2025-09-01 00:00:00', '', '100075', 1, 'UNIT', 15.00, 15.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 60.00, 60.00, 1, 120.00, 0.00, 0.00, 0.00, 0.00, 900.00, 900.00, 0, 0, '', 120.00, 0.00),
(1, 'GRN0024', '2025-09-01 00:00:00', '', '100076', 1, 'UNIT', 15.00, 15.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 120.00, 120.00, 1, 220.00, 0.00, 0.00, 0.00, 0.00, 1800.00, 1800.00, 1, 0, '', 220.00, 0.00),
(1, 'GRN0024', '2025-09-01 00:00:00', '', '100077', 1, 'UNIT', 15.00, 15.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 160.00, 160.00, 1, 260.00, 0.00, 0.00, 0.00, 0.00, 2400.00, 2400.00, 2, 0, '', 260.00, 0.00),
(1, 'GRN0025', '2025-09-01 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0026', '2025-09-02 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 100.00, 0.00, 0.00, 0.00, 0.00, 700.00, 700.00, 0, 0, '', 100.00, 0.00),
(1, 'GRN0027', '2025-09-02 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 50.00, 50.00, 1, 110.00, 0.00, 0.00, 0.00, 0.00, 500.00, 500.00, 0, 0, '', 110.00, 0.00),
(1, 'GRN0028', '2025-09-02 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 110.00, 0.00, 0.00, 0.00, 0.00, 700.00, 700.00, 0, 0, '', 110.00, 0.00),
(1, 'GRN0029', '2025-09-02 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 70.00, 70.00, 1, 110.00, 0.00, 0.00, 0.00, 0.00, 700.00, 700.00, 0, 0, '', 110.00, 0.00),
(1, 'GRN0030', '2025-09-02 00:00:00', '', '100075', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 80.00, 80.00, 1, 110.00, 0.00, 0.00, 0.00, 0.00, 800.00, 800.00, 0, 0, '', 110.00, 0.00),
(1, 'GRN0031', '2025-09-02 00:00:00', '', '100077', 1, 'UNIT', 10.00, 10.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 1.00, 0.00, 180.00, 180.00, 1, 280.00, 0.00, 0.00, 0.00, 0.00, 1800.00, 1800.00, 0, 0, '', 280.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `goodsreceivenotehed`
--

CREATE TABLE `goodsreceivenotehed` (
  `AppNo` int(11) NOT NULL,
  `GRN_No` varchar(8) NOT NULL,
  `GRN_PONo` varchar(80) NOT NULL,
  `GRN_Date` datetime NOT NULL,
  `GRN_DateORG` datetime NOT NULL,
  `GRN_Location` smallint(6) NOT NULL,
  `GRN_SupCode` varchar(8) NOT NULL,
  `GRN_InvoiceNo` varchar(12) NOT NULL,
  `GRN_Remark` varchar(150) NOT NULL,
  `GRN_IsNbtTotal` tinyint(1) DEFAULT 0,
  `GRN_IsVatTotal` tinyint(1) DEFAULT 0,
  `GRN_NbtRatioTotal` decimal(5,2) DEFAULT NULL,
  `GRN_AdditionalCharges` decimal(18,2) NOT NULL,
  `GRN_VatAmount` decimal(10,2) DEFAULT 0.00,
  `GRN_NbtAmount` decimal(10,2) DEFAULT 0.00,
  `GRN_Amount` decimal(18,2) NOT NULL,
  `GRN_NetAmount` decimal(18,2) NOT NULL,
  `GRN_DueAmount` decimal(18,2) NOT NULL,
  `GRN_ReturnAmount` decimal(18,2) NOT NULL,
  `GRN_DisAmount` decimal(18,2) NOT NULL,
  `GRN_DisPersantage` decimal(18,2) NOT NULL,
  `GRN_User` varchar(20) NOT NULL,
  `GRN_IsComplete` tinyint(4) NOT NULL,
  `GRN_IsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `goodsreceivenotehed`
--

INSERT INTO `goodsreceivenotehed` (`AppNo`, `GRN_No`, `GRN_PONo`, `GRN_Date`, `GRN_DateORG`, `GRN_Location`, `GRN_SupCode`, `GRN_InvoiceNo`, `GRN_Remark`, `GRN_IsNbtTotal`, `GRN_IsVatTotal`, `GRN_NbtRatioTotal`, `GRN_AdditionalCharges`, `GRN_VatAmount`, `GRN_NbtAmount`, `GRN_Amount`, `GRN_NetAmount`, `GRN_DueAmount`, `GRN_ReturnAmount`, `GRN_DisAmount`, `GRN_DisPersantage`, `GRN_User`, `GRN_IsComplete`, `GRN_IsCancel`) VALUES
(1, 'GRN0001', '', '2025-08-11 00:00:00', '2025-08-11 17:37:20', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 1042.90, 1042.90, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0002', '', '2025-08-11 00:00:00', '2025-08-11 17:47:47', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 1042.90, 1042.90, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0003', '', '2025-08-12 00:00:00', '2025-08-12 11:05:29', 1, 'SUP0020', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 10000.00, 10000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0004', '', '2025-08-13 00:00:00', '2025-08-13 11:50:56', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 250.00, 250.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0005', '', '2025-08-13 00:00:00', '2025-08-13 11:56:54', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 4826880.00, 4826880.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0006', '', '2025-08-13 00:00:00', '2025-08-13 12:18:37', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 2441000.00, 2441000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0007', '', '2025-08-13 00:00:00', '2025-08-13 12:38:24', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 708000.00, 708000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0008', '', '2025-08-13 00:00:00', '2025-08-13 12:47:39', 1, 'SUP0020', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 155.54, 155.54, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0009', '', '2025-08-21 00:00:00', '2025-08-21 14:54:30', 1, 'SUP0014', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0010', '', '2025-08-21 00:00:00', '2025-08-21 14:55:23', 1, 'SUP0014', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 700.00, 700.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 1),
(1, 'GRN0011', '', '2025-08-21 00:00:00', '2025-08-21 15:27:29', 1, 'SUP0014', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 700.00, 700.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0012', '', '2025-08-21 00:00:00', '2025-08-21 15:28:17', 1, 'SUP0014', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 1000.00, 1000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 1),
(1, 'GRN0013', '', '2025-08-26 00:00:00', '2025-08-26 14:09:54', 1, 'SUP0013', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 51000.00, 51000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0014', '', '2025-08-28 00:00:00', '2025-08-28 12:40:45', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 2000.00, 2000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0015', '', '2025-08-28 00:00:00', '2025-08-28 12:59:21', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 1200.00, 1200.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0016', '', '2025-08-30 00:00:00', '2025-08-30 09:32:22', 1, 'SUP0014', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0017', '', '2025-08-30 00:00:00', '2025-08-30 09:33:16', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 600.00, 600.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0018', '', '2025-08-30 00:00:00', '2025-08-30 14:15:31', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 2500.00, 2500.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0019', '', '2025-08-30 00:00:00', '2025-08-30 16:23:51', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 400.00, 400.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0020', '', '2025-08-30 00:00:00', '2025-08-30 16:24:56', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 350.00, 350.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0021', '', '2025-08-30 00:00:00', '2025-08-30 16:26:12', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 400.00, 400.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0022', '', '2025-08-30 00:00:00', '2025-08-30 16:42:46', 1, 'SUP0012', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 600.00, 600.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0023', '', '2025-09-01 00:00:00', '2025-09-01 09:22:41', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 3000.00, 3000.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0024', '', '2025-09-01 00:00:00', '2025-09-01 09:23:50', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 5100.00, 5100.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0025', '', '2025-09-01 00:00:00', '2025-09-01 10:30:58', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 1),
(1, 'GRN0026', '', '2025-09-02 00:00:00', '2025-09-02 10:46:49', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 700.00, 700.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0027', '', '2025-09-02 00:00:00', '2025-09-02 10:48:13', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 500.00, 500.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0028', '', '2025-09-02 00:00:00', '2025-09-02 10:49:12', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 700.00, 700.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 1),
(1, 'GRN0029', '', '2025-09-02 00:00:00', '2025-09-02 12:17:36', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 700.00, 700.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0030', '', '2025-09-02 00:00:00', '2025-09-02 12:18:46', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 800.00, 800.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0),
(1, 'GRN0031', '', '2025-09-02 00:00:00', '2025-09-02 15:26:54', 1, 'SUP0021', '', '', 0, 0, NULL, 0.00, 0.00, 0.00, 1800.00, 1800.00, 0.00, 0.00, 0.00, 0.00, '1', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `grnsettlementdetails`
--

CREATE TABLE `grnsettlementdetails` (
  `SupPayNo` varchar(8) NOT NULL,
  `GRNNo` varchar(10) NOT NULL,
  `CreditAmount` decimal(18,2) NOT NULL,
  `SettledAmount` decimal(18,2) NOT NULL,
  `PayAmount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `grnsettlementdetails`
--

INSERT INTO `grnsettlementdetails` (`SupPayNo`, `GRNNo`, `CreditAmount`, `SettledAmount`, `PayAmount`) VALUES
('SPM0001', 'GRN0014', 2000.00, 2000.00, 2000.00),
('SPM0001', 'GRN0015', 1200.00, 1200.00, 1200.00),
('SPM0001', 'GRN0023', 3000.00, 3000.00, 3000.00),
('SPM0002', 'GRN0024', 5100.00, 5100.00, 5100.00),
('SPM0002', 'GRN0025', 500.00, 100.00, 100.00),
('SPM0003', 'GRN0025', 500.00, 500.00, 400.00),
('SPM0003', 'GRN0026', 700.00, 100.00, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`) VALUES
(1, 'admin', 'Administrator', '#9c27b0'),
(2, 'members', 'General User', '#ff5722'),
(3, 'Cashier', 'Cashier', '#e91e63');

-- --------------------------------------------------------

--
-- Table structure for table `holiday_schedule`
--

CREATE TABLE `holiday_schedule` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `remark` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `insu_company`
--

CREATE TABLE `insu_company` (
  `InsuranceId` int(11) NOT NULL,
  `InsuranceName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_transferdtl`
--

CREATE TABLE `internal_transferdtl` (
  `TrnsNo` varchar(10) NOT NULL,
  `Location` int(11) NOT NULL,
  `TrnsDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) DEFAULT NULL,
  `ProductCode` varchar(18) NOT NULL,
  `CaseOrUnit` varchar(6) NOT NULL,
  `UnitPerCase` decimal(18,2) NOT NULL,
  `TransQty` decimal(18,2) NOT NULL,
  `CostPrice` decimal(18,2) NOT NULL,
  `TransAmount` decimal(18,2) NOT NULL,
  `PriceLevel` int(11) NOT NULL,
  `SellingPrice` decimal(18,2) NOT NULL,
  `DismissQty` decimal(18,2) NOT NULL,
  `IsSerial` tinyint(4) NOT NULL,
  `Serial` varchar(20) NOT NULL,
  `ReturnStatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_transferhed`
--

CREATE TABLE `internal_transferhed` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `TrnsNo` varchar(10) NOT NULL,
  `TransDateORG` datetime NOT NULL,
  `TrnsDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) DEFAULT NULL,
  `CostAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(100) NOT NULL,
  `TransUser` varchar(15) NOT NULL,
  `TransIsInProcess` tinyint(4) NOT NULL,
  `TransInDate` datetime NOT NULL,
  `TransInUser` varchar(15) NOT NULL,
  `TransInRemark` varchar(100) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicedtl`
--

CREATE TABLE `invoicedtl` (
  `AppNo` int(11) NOT NULL,
  `InvNo` varchar(10) NOT NULL,
  `InvLocation` smallint(6) NOT NULL,
  `InvDate` datetime NOT NULL,
  `InvLineNo` smallint(6) NOT NULL,
  `InvProductCode` varchar(18) NOT NULL,
  `InvSerialNo` varchar(50) NOT NULL,
  `InvCaseOrUnit` varchar(6) NOT NULL,
  `InvUnitPerCase` decimal(18,2) NOT NULL,
  `InvQty` decimal(18,2) NOT NULL,
  `InvFreeQty` decimal(18,2) NOT NULL,
  `InvReturnQty` decimal(18,0) NOT NULL,
  `InvPriceLevel` decimal(18,2) NOT NULL,
  `InvUnitPrice` decimal(18,2) NOT NULL,
  `InvCostPrice` decimal(18,2) NOT NULL,
  `InvDisValue` decimal(18,2) NOT NULL,
  `InvDisPercentage` decimal(18,2) NOT NULL,
  `InvTotalAmount` decimal(18,2) NOT NULL,
  `InvNetAmount` decimal(18,2) NOT NULL,
  `InvIsVat` tinyint(1) DEFAULT 0,
  `InvIsNbt` tinyint(1) DEFAULT 0,
  `InvNbtRatio` decimal(5,2) DEFAULT 1.00,
  `InvNbtAmount` decimal(18,2) DEFAULT NULL,
  `InvVatAmount` decimal(18,2) DEFAULT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `SalesPerson` int(11) DEFAULT NULL,
  `WarrantyMonth` int(11) DEFAULT NULL,
  `SellingPriceORG` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicehed`
--

CREATE TABLE `invoicehed` (
  `AppNo` int(11) NOT NULL,
  `InvType` tinyint(1) DEFAULT 1,
  `InvNo` varchar(10) NOT NULL,
  `InvLocation` smallint(6) NOT NULL,
  `Inv_PO_No` varchar(150) NOT NULL,
  `InvJobCardNo` varchar(10) DEFAULT NULL,
  `InvDate` datetime NOT NULL,
  `InvCounterNo` varchar(130) NOT NULL,
  `InvRootNo` smallint(6) NOT NULL,
  `InvCustomer` varchar(8) NOT NULL,
  `InvDisAmount` decimal(18,2) NOT NULL,
  `InvDisPercentage` decimal(18,2) NOT NULL,
  `InvCashAmount` decimal(18,2) NOT NULL,
  `InvCCardAmount` decimal(18,2) NOT NULL,
  `InvCreditAmount` decimal(18,2) NOT NULL,
  `InvReturnPayment` decimal(18,2) DEFAULT NULL,
  `InvGiftVAmount` decimal(18,2) NOT NULL,
  `InvLoyaltyAmount` decimal(18,2) NOT NULL,
  `InvStarPoints` decimal(18,2) NOT NULL,
  `InvChequeAmount` decimal(18,2) DEFAULT NULL,
  `InvAmount` decimal(18,2) NOT NULL,
  `InvIsVat` tinyint(4) NOT NULL,
  `InvVatAmount` decimal(18,2) NOT NULL,
  `InvIsNbt` tinyint(4) NOT NULL,
  `InvNbtRatioTotal` decimal(5,2) DEFAULT 1.00,
  `InvNbtAmount` decimal(18,2) NOT NULL,
  `InvNetAmount` decimal(18,2) NOT NULL,
  `InvCustomerPayment` decimal(18,2) NOT NULL,
  `InvCostAmount` decimal(18,2) NOT NULL,
  `InvRefundAmount` decimal(18,2) NOT NULL,
  `InvUser` varchar(20) NOT NULL,
  `InvHold` tinyint(4) NOT NULL,
  `InvIsCancel` tinyint(4) NOT NULL,
  `IsComplete` tinyint(4) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicepaydtl`
--

CREATE TABLE `invoicepaydtl` (
  `AppNo` int(11) NOT NULL,
  `InvNo` varchar(10) NOT NULL,
  `InvDate` datetime NOT NULL,
  `InvPayType` varchar(10) NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `Reference` varchar(20) NOT NULL,
  `InvPayAmount` decimal(18,2) NOT NULL,
  `PayRemark` varchar(100) DEFAULT NULL,
  `ReceiptNo` varchar(20) DEFAULT NULL,
  `InvCusCode` varchar(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicerefund`
--

CREATE TABLE `invoicerefund` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `RefundNo` int(11) NOT NULL,
  `RefundDate` datetime NOT NULL,
  `ReturnNo` varchar(10) NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `ReturnAmount` decimal(18,2) NOT NULL,
  `RefundAmount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoicesettlementdetails`
--

CREATE TABLE `invoicesettlementdetails` (
  `CusPayNo` varchar(8) NOT NULL,
  `InvNo` varchar(10) NOT NULL,
  `CreditAmount` decimal(18,2) NOT NULL,
  `SettledAmount` decimal(18,2) NOT NULL,
  `PayAmount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoicesettlementdetails`
--

INSERT INTO `invoicesettlementdetails` (`CusPayNo`, `InvNo`, `CreditAmount`, `SettledAmount`, `PayAmount`) VALUES
('CC0001', 'AEC0012', 1350.00, 1350.00, 1350.00),
('CC0002', 'AEC0019', 641.20, 600.00, 600.00),
('CC0005', 'AEC0022', 3720.00, 3720.00, 3720.00),
('CC0005', 'AEC0023', 253.75, 260.00, 260.00),
('CC0006', 'AEC0021', 2380.05, 1000.00, 1000.00),
('CC0007', 'AEC0021', 2380.05, 2380.05, 1380.05),
('CC0008', 'AEC0024', 372.00, 372.00, 372.00),
('CC0009', 'AEC0027', 450.00, 450.00, 450.00),
('CC0012', 'AEC0001', 111.46, 111.46, 111.46),
('CC0012', 'AEC0010', 3126.93, 3126.93, 3126.93),
('CC0012', 'AEC0011', 80.00, 80.00, 80.00);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_condition`
--

CREATE TABLE `invoice_condition` (
  `InvRemarkId` smallint(6) NOT NULL,
  `InvType` tinyint(4) DEFAULT NULL,
  `InvSubType` tinyint(4) DEFAULT NULL,
  `InvCondition` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice_condition`
--

INSERT INTO `invoice_condition` (`InvRemarkId`, `InvType`, `InvSubType`, `InvCondition`) VALUES
(1, 1, NULL, '.'),
(2, 1, NULL, 'Warranty Period as Mentioned Against Terms'),
(3, 1, NULL, 'Original Invoice must be Produced for Warranty Claims and Serial Numbers of the Items must be intact with each item.'),
(4, 1, NULL, 'Warranty covered in this sale are for carry in service which means all defective items should be brought to above mentioned address between 10.00am to 6.00pm except on Sundays and merchant Holidays.  '),
(5, 2, NULL, 'MY TECHNOLOGY (PVT) LTD. will not be responsibility for any loss of data as a result on any defect/repair/replacement work done. '),
(6, 2, NULL, 'Its strongly recommended to backup your Data to any reliable Backup  Device in order to protect your Data. '),
(7, 1, NULL, 'A period of working 14 days will be required for any replacement/repair with a shortest possible time '),
(8, 1, NULL, 'warranty does not cover for damages for item such as corrosion, scratch marks, damages against lightening, spell, food or beverages, damages, due to unauthorized Tempering Natural Disasters Etc.   ');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_dtl`
--

CREATE TABLE `invoice_dtl` (
  `InvNo` varchar(10) NOT NULL,
  `AccNo` varchar(20) NOT NULL DEFAULT '',
  `ItemType` tinyint(1) DEFAULT NULL,
  `InvLocation` smallint(6) NOT NULL,
  `InvDate` datetime DEFAULT NULL,
  `InvLineNo` smallint(6) NOT NULL,
  `InvProductCode` varchar(18) NOT NULL,
  `InvSerialNo` varchar(22) NOT NULL,
  `InvCaseOrUnit` varchar(6) NOT NULL,
  `InvUnitPerCase` decimal(18,2) NOT NULL,
  `InvQty` decimal(18,2) NOT NULL,
  `InvFreeQty` decimal(18,2) NOT NULL,
  `InvReturnQty` decimal(18,0) NOT NULL,
  `InvPriceLevel` decimal(18,2) NOT NULL,
  `InvUnitPrice` decimal(18,2) NOT NULL,
  `InvCostPrice` decimal(18,2) NOT NULL,
  `InvDisValue` decimal(18,2) NOT NULL,
  `InvDisPercentage` decimal(18,2) NOT NULL,
  `InvTotalAmount` decimal(18,2) NOT NULL,
  `InvNetAmount` decimal(18,2) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `SalesPerson` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_extra_amount`
--

CREATE TABLE `invoice_extra_amount` (
  `AccNo` varchar(20) NOT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `PayDate` date NOT NULL DEFAULT '0000-00-00',
  `PayDesc` varchar(100) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `ExtraNo` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_hed`
--

CREATE TABLE `invoice_hed` (
  `InvNo` varchar(10) NOT NULL,
  `AccNo` varchar(15) DEFAULT NULL,
  `Location` varchar(10) DEFAULT NULL,
  `InvDate` datetime DEFAULT NULL,
  `InvType` varchar(10) DEFAULT NULL,
  `ItemType` varchar(10) DEFAULT NULL,
  `TotalAmount` decimal(20,2) DEFAULT NULL,
  `DisPercentage` decimal(10,2) DEFAULT NULL,
  `DisAmount` decimal(20,2) DEFAULT NULL,
  `CashPayment` decimal(20,2) DEFAULT NULL,
  `DownPayment` decimal(20,2) DEFAULT NULL,
  `TotalExCharges` decimal(20,2) DEFAULT NULL,
  `RefundAmount` decimal(20,2) DEFAULT NULL,
  `TotalExAmount` decimal(20,2) DEFAULT NULL,
  `TotalDwPayment` decimal(20,2) DEFAULT NULL,
  `QuarterPayment` decimal(20,2) DEFAULT NULL,
  `FinalAmount` decimal(20,2) DEFAULT NULL,
  `InterestTerm` int(11) DEFAULT NULL,
  `InterestRate` decimal(10,2) DEFAULT NULL,
  `Interest` int(11) DEFAULT NULL,
  `GrossAmount` decimal(20,2) DEFAULT NULL,
  `Installments` int(11) DEFAULT NULL,
  `TotalPaid` decimal(20,2) DEFAULT 0.00,
  `TotalDue` decimal(20,2) DEFAULT 0.00,
  `InstallAmount` decimal(20,2) DEFAULT NULL,
  `InvUser` int(11) DEFAULT NULL,
  `IsCancel` tinyint(1) DEFAULT 0,
  `IsComplete` tinyint(1) DEFAULT 0,
  `IsReturn` tinyint(1) DEFAULT 0,
  `payt_type` int(11) DEFAULT NULL,
  `pay_date` datetime DEFAULT NULL,
  `chequeAmount` decimal(20,2) DEFAULT NULL,
  `DueAmount` decimal(20,2) NOT NULL,
  `SeettuNo` int(11) NOT NULL,
  `OverPayment` decimal(20,2) NOT NULL,
  `CusCode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_jobdescription`
--

CREATE TABLE `inv_jobdescription` (
  `JobDescNo` int(11) NOT NULL,
  `JobDescription` varchar(255) DEFAULT NULL,
  `jobtype` tinyint(4) DEFAULT NULL,
  `JobCost` decimal(10,2) DEFAULT NULL,
  `isVat` tinyint(1) DEFAULT 0,
  `isNbt` tinyint(1) DEFAULT 0,
  `nbtRatio` decimal(5,2) DEFAULT 1.00,
  `DescCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inv_type`
--

CREATE TABLE `inv_type` (
  `invtype_id` tinyint(4) NOT NULL,
  `invtype` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inv_type`
--

INSERT INTO `inv_type` (`invtype_id`, `invtype`) VALUES
(1, 'Sales Invoice'),
(2, 'Job Invoice'),
(3, 'Temp. Job Invoice'),
(4, 'Estimate'),
(5, 'JobCard'),
(6, 'Purchase Order');

-- --------------------------------------------------------

--
-- Table structure for table `issuenote_dtl`
--

CREATE TABLE `issuenote_dtl` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `JobNo` varchar(50) NOT NULL,
  `SalesInvLocation` smallint(6) NOT NULL,
  `SalesInvDate` datetime NOT NULL,
  `SalesInvLineNo` smallint(6) NOT NULL,
  `SalesProductName` varchar(100) DEFAULT NULL,
  `SalesProductCode` varchar(18) NOT NULL,
  `SalesSerialNo` varchar(50) NOT NULL,
  `SalesCaseOrUnit` varchar(6) NOT NULL,
  `SalesUnitPerCase` decimal(18,2) NOT NULL,
  `SalesQty` decimal(18,2) NOT NULL,
  `SalesFreeQty` decimal(18,2) NOT NULL,
  `SalesReturnQty` decimal(18,2) NOT NULL,
  `SalesPriceLevel` decimal(18,2) NOT NULL,
  `SalesUnitPrice` decimal(18,2) NOT NULL,
  `SalesCostPrice` decimal(18,2) NOT NULL,
  `SalesDisValue` decimal(18,2) NOT NULL,
  `SalesDisPercentage` decimal(18,2) NOT NULL,
  `SalesTotalAmount` decimal(18,2) NOT NULL,
  `SalesInvNetAmount` decimal(18,2) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `SalesPerson` int(11) DEFAULT NULL,
  `WarrantyMonth` int(11) DEFAULT NULL,
  `SalesIsVat` tinyint(1) DEFAULT 0,
  `SalesNbtAmount` decimal(18,2) DEFAULT NULL,
  `SalesVatAmount` decimal(18,2) DEFAULT NULL,
  `SalesNbtRatio` decimal(5,2) DEFAULT 1.00,
  `SalesIsNbt` tinyint(1) DEFAULT 0,
  `SellingPriceORG` decimal(18,2) DEFAULT NULL,
  `JobType` int(11) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issuenote_hed`
--

CREATE TABLE `issuenote_hed` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `SalesInvType` tinyint(1) DEFAULT NULL,
  `SalesLocation` smallint(6) NOT NULL,
  `SalesOrderNo` varchar(150) NOT NULL,
  `SalesOrgDate` datetime DEFAULT NULL,
  `SalesDate` datetime NOT NULL,
  `SalesInsCompany` tinyint(4) DEFAULT NULL,
  `SalesCounterNo` varchar(130) NOT NULL,
  `SalesVehicle` varchar(20) DEFAULT NULL,
  `SalesRootNo` smallint(6) NOT NULL,
  `SalesCustomer` varchar(8) NOT NULL,
  `SalesDisAmount` decimal(18,2) NOT NULL,
  `SalesDisPercentage` decimal(18,2) NOT NULL,
  `SalesCashAmount` decimal(18,2) NOT NULL,
  `SalesCCardAmount` decimal(18,2) NOT NULL,
  `SalesCreditAmount` decimal(18,2) NOT NULL,
  `SalesAdvancePayment` decimal(18,2) DEFAULT 0.00,
  `AdvancePayNo` varchar(10) DEFAULT NULL,
  `SalesReturnAmount` decimal(18,2) DEFAULT 0.00,
  `SalesReturnPayment` decimal(18,2) DEFAULT NULL,
  `SalesGiftVAmount` decimal(18,2) NOT NULL,
  `SalesLoyaltyAmount` decimal(18,2) NOT NULL,
  `SalesStarPoints` decimal(18,2) NOT NULL,
  `SalesChequeAmount` decimal(18,2) DEFAULT NULL,
  `SalesInvAmount` decimal(18,2) NOT NULL,
  `SalesIsVat` tinyint(4) NOT NULL,
  `SalesVatAmount` decimal(18,2) NOT NULL,
  `SalesNbtRatio` decimal(5,2) DEFAULT NULL,
  `SalesIsNbt` tinyint(4) NOT NULL,
  `SalesNbtAmount` decimal(18,2) NOT NULL,
  `SalesShipping` decimal(8,2) DEFAULT 0.00,
  `SalesShippingLabel` varchar(30) DEFAULT NULL,
  `SalesBankAmount` decimal(18,2) DEFAULT 0.00,
  `SalesBankAcc` varchar(10) DEFAULT NULL,
  `SalesNetAmount` decimal(18,2) NOT NULL,
  `SalesCustomerPayment` decimal(18,2) NOT NULL,
  `SalesCostAmount` decimal(18,2) NOT NULL,
  `SalesPONumber` varchar(50) DEFAULT NULL,
  `SalesRefundAmount` decimal(18,2) NOT NULL,
  `SalesReceiver` varchar(100) DEFAULT NULL,
  `SalesRecNic` varchar(12) DEFAULT NULL,
  `SalesCommsion` decimal(10,2) DEFAULT NULL,
  `SalesComCus` varchar(10) DEFAULT NULL,
  `SalesInvUser` varchar(20) NOT NULL,
  `SalesPerson` varchar(50) DEFAULT NULL,
  `SalesInvHold` tinyint(4) NOT NULL,
  `InvIsCancel` tinyint(4) NOT NULL,
  `IsComplete` tinyint(4) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL,
  `salesInvRemark` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_charges`
--

CREATE TABLE `item_charges` (
  `ChargeId` int(11) NOT NULL,
  `ItemType` int(11) DEFAULT NULL,
  `ItemCategory` int(11) NOT NULL,
  `ChargeType` int(11) DEFAULT NULL,
  `ChargeAmount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_interest`
--

CREATE TABLE `item_interest` (
  `IntId` int(11) NOT NULL,
  `ItemType` int(11) DEFAULT NULL,
  `IntTerm` int(11) DEFAULT NULL,
  `Interest` decimal(10,2) DEFAULT NULL,
  `installment` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_payment_dtl`
--

CREATE TABLE `item_payment_dtl` (
  `AccNo` varchar(20) NOT NULL,
  `InvNo` varchar(20) DEFAULT '',
  `PaymentDate` date DEFAULT NULL,
  `Month` int(11) NOT NULL DEFAULT 0,
  `MonPayment` decimal(20,2) DEFAULT NULL,
  `Principal` decimal(20,2) DEFAULT NULL,
  `Interest` decimal(20,2) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `Balance` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcarddtl`
--

CREATE TABLE `jobcarddtl` (
  `JobCardNo` varchar(10) NOT NULL,
  `JobDescription` varchar(255) NOT NULL,
  `JobDescId` tinyint(4) NOT NULL,
  `JobCategory` smallint(6) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcardhed`
--

CREATE TABLE `jobcardhed` (
  `JLocation` tinyint(1) DEFAULT NULL,
  `JobCardNo` varchar(10) NOT NULL,
  `JCompanyCode` varchar(10) NOT NULL,
  `JCustomer` varchar(10) NOT NULL,
  `JRegNo` varchar(15) NOT NULL,
  `JPayType` tinyint(1) DEFAULT NULL,
  `JCusType` tinyint(4) NOT NULL,
  `JCusCompany` int(11) NOT NULL,
  `JIsInsDoc` varchar(20) DEFAULT NULL,
  `OdoIn` int(11) NOT NULL,
  `OdoOut` int(11) NOT NULL,
  `OdoOutUnit` tinyint(1) DEFAULT 1,
  `OdoInUnit` tinyint(1) DEFAULT 1,
  `PrevJobNo` varchar(20) NOT NULL,
  `SparePartJobNo` varchar(20) NOT NULL,
  `serviceAdvisor` varchar(50) NOT NULL,
  `advisorContact` varchar(20) NOT NULL,
  `appoimnetDate` datetime NOT NULL,
  `NextService` int(11) DEFAULT NULL,
  `deliveryDate` datetime NOT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `closeDate` datetime DEFAULT NULL,
  `assignTo` varchar(10) DEFAULT NULL,
  `JestimateNo` varchar(10) NOT NULL,
  `JJobType` int(11) NOT NULL,
  `JInvUser` tinyint(4) DEFAULT NULL,
  `jobDescription` varchar(200) DEFAULT NULL,
  `Jsection` int(11) NOT NULL,
  `Advance` decimal(20,2) NOT NULL,
  `JAdvanceNo` varchar(10) DEFAULT NULL,
  `IsCompelte` tinyint(1) NOT NULL,
  `PODoc` varchar(50) DEFAULT NULL,
  `IsCancel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcardtype`
--

CREATE TABLE `jobcardtype` (
  `JobCardNo` varchar(10) NOT NULL,
  `JobTypeId` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcategory`
--

CREATE TABLE `jobcategory` (
  `jobcategory_id` int(11) NOT NULL,
  `job_category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcompanyinvoicedetails`
--

CREATE TABLE `jobcompanyinvoicedetails` (
  `AppNo` smallint(6) NOT NULL,
  `ComInvoiceDate` datetime NOT NULL,
  `ComInvoiceNo` varchar(10) NOT NULL,
  `ComLocation` smallint(6) NOT NULL,
  `ComCusCode` varchar(10) NOT NULL,
  `ComNetAmount` decimal(18,2) NOT NULL,
  `ComCreditAmount` decimal(18,2) NOT NULL,
  `ComSettledAmount` decimal(18,2) NOT NULL,
  `ComIsCloseInvoice` tinyint(4) NOT NULL,
  `ComIsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobcreditinvoicedetails`
--

CREATE TABLE `jobcreditinvoicedetails` (
  `AppNo` smallint(6) NOT NULL,
  `InvoiceDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `CusCode` varchar(10) NOT NULL,
  `NetAmount` decimal(18,2) NOT NULL,
  `CreditAmount` decimal(18,2) NOT NULL,
  `SettledAmount` decimal(18,2) NOT NULL,
  `IsCloseInvoice` tinyint(4) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobdescription`
--

CREATE TABLE `jobdescription` (
  `JobDescNo` int(11) NOT NULL,
  `JobDescription` varchar(255) DEFAULT NULL,
  `jobcard_category` varchar(255) DEFAULT NULL,
  `JobDescCode` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobinvoicedtl`
--

CREATE TABLE `jobinvoicedtl` (
  `jobinvoicedtlid` int(11) NOT NULL,
  `JobInvNo` varchar(10) NOT NULL,
  `JobCardNo` varchar(10) NOT NULL,
  `EstLineNo` smallint(6) DEFAULT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JobOrder` tinyint(1) DEFAULT NULL,
  `JobType` varchar(255) DEFAULT NULL,
  `JobCode` varchar(255) DEFAULT NULL,
  `JobDescription` varchar(255) DEFAULT NULL,
  `SalesSerialNo` varchar(50) NOT NULL,
  `JobQty` decimal(11,2) DEFAULT NULL,
  `JobCost` decimal(10,2) DEFAULT 0.00,
  `JobPrice` decimal(10,2) DEFAULT NULL,
  `JobReturnQty` decimal(8,2) DEFAULT NULL,
  `JobIsVat` tinyint(1) DEFAULT 0,
  `JobIsNbt` tinyint(1) DEFAULT 0,
  `JobNbtRatio` decimal(5,2) DEFAULT 1.00,
  `JobTotalAmount` decimal(10,2) DEFAULT 0.00,
  `JobDiscount` decimal(10,2) DEFAULT 0.00,
  `JobVatAmount` decimal(10,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(10,2) DEFAULT 0.00,
  `JobNetAmount` decimal(10,2) DEFAULT 0.00,
  `JobDisValue` decimal(10,2) DEFAULT 0.00,
  `JobDisPercentage` decimal(10,2) DEFAULT 0.00,
  `JobDiscountType` tinyint(4) DEFAULT NULL,
  `IsReturn` tinyint(1) DEFAULT 0,
  `JobinvoiceTimestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobinvoicehed`
--

CREATE TABLE `jobinvoicehed` (
  `JobInvNo` varchar(10) NOT NULL DEFAULT '',
  `JobEstimateNo` varchar(10) DEFAULT NULL,
  `JobSupplimentry` varchar(10) DEFAULT NULL,
  `JobCardNo` varchar(10) NOT NULL DEFAULT '',
  `JInsCompany` int(11) DEFAULT NULL,
  `JCompanyCode` varchar(10) NOT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JCustomer` varchar(10) DEFAULT NULL,
  `JRegNo` varchar(15) DEFAULT NULL,
  `JobInvoiceDate` datetime NOT NULL,
  `CustomerPayment` decimal(20,2) DEFAULT 0.00,
  `JobAdvance` decimal(20,2) DEFAULT NULL,
  `JobTotalDiscount` decimal(20,2) DEFAULT 0.00,
  `JobNetAmount` decimal(20,2) DEFAULT 0.00,
  `JobCostAmount` decimal(20,2) DEFAULT 0.00,
  `JobTotalAmount` decimal(20,2) DEFAULT 0.00,
  `JobIsVatTotal` tinyint(1) DEFAULT 0,
  `JobIsNbtTotal` tinyint(1) DEFAULT 0,
  `JobNbtRatioTotal` decimal(5,2) DEFAULT 1.00,
  `JobVatAmount` decimal(20,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(20,2) DEFAULT 0.00,
  `JobBankAcc` varchar(20) DEFAULT NULL,
  `JobBankAmount` decimal(20,2) DEFAULT NULL,
  `JobCashAmount` decimal(20,2) DEFAULT NULL,
  `JobCreditAmount` decimal(20,2) DEFAULT NULL,
  `JobCompanyAmount` decimal(20,2) DEFAULT NULL,
  `JobChequeAmount` decimal(20,2) DEFAULT NULL,
  `JobReturnAmount` decimal(10,2) DEFAULT 0.00,
  `JobReturnPayment` decimal(10,2) NOT NULL,
  `JobCardAmount` decimal(20,2) DEFAULT NULL,
  `ThirdCashAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCreditAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdChequeAmount` decimal(20,2) DEFAULT 0.00,
  `AdvancePayNo` varchar(10) DEFAULT NULL,
  `ThirdCardAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCustomerPayment` decimal(20,2) DEFAULT 0.00,
  `EstType` tinyint(4) NOT NULL,
  `JJobType` int(11) NOT NULL,
  `IsCompelte` tinyint(1) NOT NULL,
  `IsCancel` tinyint(1) NOT NULL,
  `IsEdit` tinyint(1) DEFAULT 0,
  `TempNo` varchar(10) DEFAULT NULL,
  `JobComCus` varchar(10) DEFAULT NULL,
  `JobCommsion` decimal(10,2) DEFAULT 0.00,
  `JobInvUser` tinyint(4) DEFAULT NULL,
  `PartInvType` tinyint(1) DEFAULT 1,
  `InvoiceType` tinyint(1) DEFAULT 1,
  `InvRemark` longtext DEFAULT NULL,
  `IsPayment` tinyint(1) DEFAULT 0,
  `mileageout` int(11) DEFAULT NULL,
  `mileageoutUnit` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobinvoicepaydtl`
--

CREATE TABLE `jobinvoicepaydtl` (
  `JobInvNo` varchar(10) NOT NULL,
  `JobInvDate` datetime NOT NULL,
  `JobInvPayType` varchar(10) NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `Reference` varchar(20) NOT NULL,
  `JobInvPayAmount` decimal(18,2) NOT NULL,
  `InsCompany` varchar(10) DEFAULT NULL,
  `PayRemark` varchar(100) DEFAULT NULL,
  `ReceiptNo` varchar(10) DEFAULT NULL,
  `ReceiptAmount` decimal(18,2) DEFAULT NULL,
  `PartInvoiceNo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobpackagedtl`
--

CREATE TABLE `jobpackagedtl` (
  `jobinvoicedtlid` int(11) NOT NULL,
  `JobInvNo` varchar(10) NOT NULL,
  `JobCardNo` varchar(10) NOT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JobOrder` tinyint(1) DEFAULT NULL,
  `JobType` varchar(255) DEFAULT NULL,
  `JobCode` varchar(255) DEFAULT NULL,
  `JobDescription` varchar(255) DEFAULT NULL,
  `JobQty` decimal(11,2) DEFAULT NULL,
  `JobCost` decimal(10,2) DEFAULT 0.00,
  `JobPrice` decimal(10,2) DEFAULT NULL,
  `JobIsVat` tinyint(1) DEFAULT 0,
  `JobIsNbt` tinyint(1) DEFAULT 0,
  `JobNbtRatio` decimal(5,2) DEFAULT 1.00,
  `JobTotalAmount` decimal(10,2) DEFAULT 0.00,
  `JobDiscount` decimal(10,2) DEFAULT 0.00,
  `JobVatAmount` decimal(10,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(10,2) DEFAULT 0.00,
  `JobNetAmount` decimal(10,2) DEFAULT 0.00,
  `JobDisValue` decimal(10,2) DEFAULT 0.00,
  `JobDisPercentage` decimal(10,2) DEFAULT 0.00,
  `JobDiscountType` tinyint(4) DEFAULT NULL,
  `JobinvoiceTimestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobpackagehed`
--

CREATE TABLE `jobpackagehed` (
  `JobInvNo` varchar(10) NOT NULL DEFAULT '',
  `JobEstimateNo` varchar(100) DEFAULT NULL,
  `JobSupplimentry` varchar(10) DEFAULT NULL,
  `JobCardNo` varchar(10) NOT NULL DEFAULT '',
  `JInsCompany` int(11) DEFAULT NULL,
  `JCompanyCode` varchar(10) NOT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JCustomer` varchar(10) DEFAULT NULL,
  `JRegNo` varchar(25) DEFAULT NULL,
  `JobInvoiceDate` datetime NOT NULL,
  `CustomerPayment` decimal(20,2) DEFAULT 0.00,
  `JobAdvance` decimal(20,2) DEFAULT NULL,
  `JobTotalDiscount` decimal(20,2) DEFAULT 0.00,
  `JobNetAmount` decimal(20,2) DEFAULT 0.00,
  `JobCostAmount` decimal(20,2) DEFAULT 0.00,
  `JobTotalAmount` decimal(20,2) DEFAULT 0.00,
  `JobIsVatTotal` tinyint(1) DEFAULT 0,
  `JobIsNbtTotal` tinyint(1) DEFAULT 0,
  `JobNbtRatioTotal` decimal(5,2) DEFAULT 1.00,
  `JobVatAmount` decimal(20,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(20,2) DEFAULT 0.00,
  `JobCashAmount` decimal(20,2) DEFAULT NULL,
  `JobCreditAmount` decimal(20,2) DEFAULT NULL,
  `JobCompanyAmount` decimal(20,2) DEFAULT NULL,
  `JobChequeAmount` decimal(20,2) DEFAULT NULL,
  `JobCardAmount` decimal(20,2) DEFAULT NULL,
  `ThirdCashAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCreditAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdChequeAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCardAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCustomerPayment` decimal(20,2) DEFAULT 0.00,
  `EstType` tinyint(4) NOT NULL,
  `JJobType` int(11) NOT NULL,
  `IsCompelte` tinyint(1) NOT NULL,
  `IsCancel` tinyint(1) NOT NULL,
  `IsEdit` tinyint(1) DEFAULT 0,
  `TempNo` varchar(10) DEFAULT NULL,
  `JobInvUser` tinyint(4) DEFAULT NULL,
  `PartInvType` tinyint(1) DEFAULT 1,
  `InvoiceType` tinyint(1) DEFAULT 1,
  `IsPayment` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobtype`
--

CREATE TABLE `jobtype` (
  `jobtype_id` int(11) NOT NULL,
  `jobhead` tinyint(1) DEFAULT NULL,
  `jobtype_code` varchar(10) DEFAULT NULL,
  `jobtype_name` varchar(100) DEFAULT NULL,
  `jobtype_order` tinyint(4) DEFAULT NULL,
  `jobtype_comment` varchar(255) DEFAULT NULL,
  `isVat` tinyint(1) DEFAULT 0,
  `isNbt` tinyint(1) DEFAULT 0,
  `nbtRatio` decimal(5,2) DEFAULT 1.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobtypeheader`
--

CREATE TABLE `jobtypeheader` (
  `jobhead_id` int(11) NOT NULL,
  `jobhead_name` varchar(100) DEFAULT NULL,
  `jobhead_order` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobwoker`
--

CREATE TABLE `jobwoker` (
  `AppNo` tinyint(1) DEFAULT NULL,
  `jworkid` int(11) NOT NULL,
  `JCardNo` varchar(10) NOT NULL,
  `add_date` datetime NOT NULL,
  `JobWokerId` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_condition`
--

CREATE TABLE `job_condition` (
  `JobConId` tinyint(4) NOT NULL,
  `JobCondition` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job_condition`
--

INSERT INTO `job_condition` (`JobConId`, `JobCondition`) VALUES
(1, 'New Job'),
(2, 'Repeat');

-- --------------------------------------------------------

--
-- Table structure for table `job_document`
--

CREATE TABLE `job_document` (
  `doc_id` int(11) NOT NULL,
  `job_no` varchar(10) DEFAULT NULL,
  `doc_name` varchar(100) DEFAULT NULL,
  `upload_by` tinyint(4) DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_section`
--

CREATE TABLE `job_section` (
  `JobSecNo` int(11) NOT NULL,
  `JobSection` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_status`
--

CREATE TABLE `job_status` (
  `status_id` tinyint(4) NOT NULL DEFAULT 0,
  `status_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `job_status`
--

INSERT INTO `job_status` (`status_id`, `status_name`) VALUES
(0, 'Pending'),
(1, 'Job Started'),
(2, 'Job Finished'),
(3, 'Job Closed'),
(4, 'Job Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `location`) VALUES
(1, 'Ampara');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `make`
--

CREATE TABLE `make` (
  `make_id` int(11) NOT NULL,
  `make` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materialrequestnotedtl`
--

CREATE TABLE `materialrequestnotedtl` (
  `MrnNo` varchar(10) NOT NULL,
  `Location` int(11) NOT NULL,
  `MrnDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `ProductCode` varchar(18) NOT NULL,
  `ProBrand` varchar(30) DEFAULT NULL,
  `ProQuality` varchar(30) DEFAULT NULL,
  `ReceiveQuality` varchar(30) DEFAULT NULL,
  `ReceiveBrand` varchar(30) DEFAULT NULL,
  `ProName` varchar(150) NOT NULL,
  `CaseOrUnit` varchar(6) NOT NULL,
  `UnitPerCase` decimal(18,2) NOT NULL,
  `RequestQty` decimal(18,2) NOT NULL,
  `CostPrice` decimal(18,2) NOT NULL,
  `TotalAmount` decimal(18,2) NOT NULL,
  `NetAmount` decimal(18,2) DEFAULT 0.00,
  `PriceLevel` int(11) NOT NULL,
  `SellingPrice` decimal(18,2) NOT NULL,
  `ReceiveQty` decimal(5,2) NOT NULL,
  `IsSerial` tinyint(1) NOT NULL,
  `Request` tinyint(1) NOT NULL,
  `ReceiveDate` datetime NOT NULL,
  `Receive` tinyint(1) NOT NULL,
  `MrnNbtRatio` decimal(5,2) DEFAULT 1.00,
  `MrnIsNbt` tinyint(1) DEFAULT 0,
  `MrnIsVat` tinyint(1) DEFAULT 0,
  `MrnNbtAmount` decimal(20,2) DEFAULT 0.00,
  `MrnVatAmount` decimal(20,2) DEFAULT 0.00,
  `Serial` varchar(40) NOT NULL,
  `ReturnStatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materialrequestnotehed`
--

CREATE TABLE `materialrequestnotehed` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `MrnNo` varchar(10) NOT NULL,
  `MrnDateORG` datetime NOT NULL,
  `MrnDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `ToCustomer` varchar(20) DEFAULT NULL,
  `MrnEstimateNo` varchar(20) DEFAULT NULL,
  `MrnJobNo` varchar(20) DEFAULT NULL,
  `CostAmount` decimal(18,2) NOT NULL,
  `MrnRemark` varchar(100) NOT NULL,
  `MrnUser` varchar(15) NOT NULL,
  `MrnIsReceive` tinyint(4) NOT NULL,
  `ReceivedDate` datetime NOT NULL,
  `MrnOutUser` varchar(15) NOT NULL,
  `MrnInRemark` varchar(100) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsConfirm` tinyint(1) DEFAULT 0,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `measure`
--

CREATE TABLE `measure` (
  `UOM_No` smallint(6) NOT NULL,
  `UOM_Name` varchar(20) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `measure`
--

INSERT INTO `measure` (`UOM_No`, `UOM_Name`, `IsActive`) VALUES
(1, 'PCS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

CREATE TABLE `model` (
  `model_id` int(11) NOT NULL,
  `makeid` int(11) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `model_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parttype`
--

CREATE TABLE `parttype` (
  `parttype_id` int(11) NOT NULL,
  `parttype_code` varchar(10) DEFAULT NULL,
  `parttype_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `parttype`
--

INSERT INTO `parttype` (`parttype_id`, `parttype_code`, `parttype_name`) VALUES
(1, 'GP', 'GENUINE PARTS'),
(2, 'NON', 'NONGENUINE PARTS'),
(3, 'UP', 'USED PARTS');

-- --------------------------------------------------------

--
-- Table structure for table `paytype`
--

CREATE TABLE `paytype` (
  `payTypeId` int(11) NOT NULL,
  `payType` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `paytype`
--

INSERT INTO `paytype` (`payTypeId`, `payType`) VALUES
(1, 'Cash'),
(2, 'Credit'),
(3, 'Cheque'),
(4, 'Card'),
(7, 'Due On Receipt'),
(8, 'Bank Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `penalty_setting`
--

CREATE TABLE `penalty_setting` (
  `Id` int(11) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penalty_setting`
--

INSERT INTO `penalty_setting` (`Id`, `rate`, `date`) VALUES
(2, 5.00, 5);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) DEFAULT NULL,
  `permission_class` varchar(100) NOT NULL DEFAULT '',
  `permission_function` varchar(255) DEFAULT NULL,
  `per_user` int(11) NOT NULL DEFAULT 0,
  `isClass` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`permission_id`, `permission_name`, `permission_class`, `permission_function`, `per_user`, `isClass`) VALUES
(16, '[\"cancel_grn\"]', 'grn', '[\"cancel_grn\"]', 5, 0),
(17, '[\"cancel_grn\"]', 'grn', '[\"cancel_grn\"]', 6, 0),
(10, '[\"cancel_invoice\"]', 'invoice', '[\"cancel_invoice\"]', 5, 0),
(11, '[\"cancel_invoice\"]', 'invoice', '[\"cancel_invoice\"]', 6, 0),
(5, '[\"cancel_job\"]', 'job', '[\"cancel_job\"]', 1, 0),
(28, '[\"index\",\"cancel_job\",\"view_job\"]', 'job', '[\"index\",\"cancel_job\",\"view_job\"]', 2, 0),
(8, '-', 'job', '-', 5, 0),
(9, '[\"cancel_job\"]', 'job', '[\"cancel_job\"]', 6, 0),
(14, '[\"cancel_cus_payment\",\"cancel_cus_payment\"]', 'payment', '[\"cancel_cus_payment\",\"cancel_cus_payment\"]', 5, 0),
(15, '[\"cancel_cus_payment\",\"cancel_cus_payment\"]', 'payment', '[\"cancel_cus_payment\",\"cancel_cus_payment\"]', 6, 0),
(24, '[\"user_permission\"]', 'permission', '[\"user_permission\"]', 3, 0),
(25, '[\"user_permission\"]', 'permission', '[\"user_permission\"]', 4, 0),
(27, '[\"user_permission\"]', 'permission', '[\"user_permission\"]', 6, 0),
(7, '-', 'report', '-', 6, 1),
(19, '[\"cancelInvoice\"]', 'salesinvoice', '[\"cancelInvoice\"]', 6, 0),
(12, '[\"cancel_transer\"]', 'transer', '[\"cancel_transer\"]', 6, 0),
(21, '-', 'users', '-', 3, 0),
(20, '[\"index\",\"create\"]', 'users', '[\"index\",\"create\"]', 4, 0),
(23, '[\"index\",\"create\"]', 'users', '[\"index\",\"create\"]', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pricelevel`
--

CREATE TABLE `pricelevel` (
  `PL_No` smallint(6) NOT NULL,
  `PriceLevel` varchar(30) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pricelevel`
--

INSERT INTO `pricelevel` (`PL_No`, `PriceLevel`, `IsActive`) VALUES
(1, 'RETAIL PRICE', 1),
(2, 'WHOLE SALES PRICE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pricestock`
--

CREATE TABLE `pricestock` (
  `PSCode` varchar(20) NOT NULL,
  `PSLocation` smallint(6) NOT NULL,
  `PSPriceLevel` smallint(6) NOT NULL,
  `Price` decimal(18,2) NOT NULL,
  `Stock` decimal(18,2) NOT NULL,
  `UnitCost` decimal(18,2) NOT NULL,
  `Damage` int(11) NOT NULL DEFAULT 0,
  `Expired` int(11) NOT NULL DEFAULT 0,
  `WholesalesPrice` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pricestock`
--

INSERT INTO `pricestock` (`PSCode`, `PSLocation`, `PSPriceLevel`, `Price`, `Stock`, `UnitCost`, `Damage`, `Expired`, `WholesalesPrice`) VALUES
('100001', 1, 1, 372.00, 923.00, 350.50, 0, 5, 0),
('100002', 1, 1, 282.00, 910.00, 250.00, 3, 0, 0),
('100004', 1, 1, 448.00, -18.00, 423.00, 2, 0, NULL),
('100004', 1, 1, 448.56, 965.00, 423.00, 2, 0, 0),
('100005', 1, 1, 187.00, -107.00, 155.54, 0, 0, NULL),
('100005', 1, 1, 187.25, 965.00, 155.54, 0, 0, 0),
('100007', 1, 1, 111.00, -114.00, 104.29, 1, 1, NULL),
('100007', 1, 1, 111.46, 859.00, 104.29, 0, 0, 0),
('100008', 1, 1, 91.00, -97.00, 85.00, 0, 0, NULL),
('100008', 1, 1, 91.60, 1327.00, 85.00, 1, 0, 0),
('100009', 1, 1, 91.00, -72.00, 85.00, 0, 0, NULL),
('100009', 1, 1, 91.60, 696.00, 85.00, 10, 2, 0),
('100010', 1, 1, 111.00, -61.00, 104.29, 1, 10, NULL),
('100010', 1, 1, 111.46, 950.00, 104.29, 0, 0, 0),
('100012', 1, 1, 187.00, -48.00, 155.54, 0, 0, NULL),
('100012', 1, 1, 187.25, 976.00, 155.54, 0, 0, 0),
('100014', 1, 1, 282.00, 899.00, 263.50, 0, 2, 0),
('100015', 1, 1, 372.00, 915.00, 350.50, 0, 0, 0),
('100016', 1, 1, 448.00, -18.00, 422.78, 0, 0, NULL),
('100016', 1, 1, 448.56, 982.00, 422.78, 0, 0, 0),
('100017', 1, 1, 91.00, -48.00, 85.00, 0, 0, NULL),
('100017', 1, 1, 91.60, 882.00, 85.00, 0, 0, 0),
('100018', 1, 1, 111.00, -90.00, 104.29, 0, 0, NULL),
('100018', 1, 1, 111.46, 1000.00, 104.29, 0, 0, 0),
('100020', 1, 1, 165.00, -48.00, 155.54, 1, 0, 0),
('100020', 1, 1, 165.63, 952.00, 155.54, 0, 0, 0),
('100022', 1, 1, 282.00, 917.00, 263.50, 0, 0, 0),
('100023', 1, 1, 372.00, 970.00, 350.50, 0, 0, 0),
('100024', 1, 1, 448.00, -9.00, 422.78, 0, 0, NULL),
('100024', 1, 1, 448.56, 982.00, 422.78, 0, 0, 0),
('100025', 1, 1, 91.00, -24.00, 85.00, 0, 0, NULL),
('100025', 1, 1, 91.60, 989.00, 85.00, 0, 0, 0),
('100026', 1, 1, 111.00, -71.00, 104.29, 0, 0, NULL),
('100026', 1, 1, 111.46, 1000.00, 104.29, 0, 0, 0),
('100027', 1, 1, 187.25, 1000.00, 155.54, 0, 0, 0),
('100029', 1, 1, 372.00, 988.00, 350.50, 0, 0, 0),
('100047', 1, 1, 130.00, 99.00, 100.00, 10, 0, 0),
('100048', 1, 1, 91.00, -24.00, 85.00, 0, 0, NULL),
('100048', 1, 1, 91.60, 1000.00, 85.00, 2, 0, 0),
('100049', 1, 1, 92.00, -71.00, 87.00, 0, 0, NULL),
('100049', 1, 1, 92.88, 940.00, 87.00, 0, 0, 0),
('100050', 1, 1, 138.00, 951.00, 130.00, 0, 0, 0),
('100051', 1, 1, 252.00, -3.00, 236.00, 0, 0, NULL),
('100051', 1, 1, 252.50, 948.00, 236.00, 0, 0, 0),
('100051', 1, 1, 253.00, -24.00, 236.00, 0, 0, NULL),
('100051', 1, 1, 253.75, 999.00, 236.00, 0, 0, 0),
('100052', 1, 1, 361.00, 980.00, 341.00, 0, 0, 0),
('100053', 1, 1, 91.00, -24.00, 85.00, 1, 0, NULL),
('100053', 1, 1, 91.60, 991.00, 85.00, 0, 0, 0),
('100054', 1, 1, 92.00, -71.00, 87.00, 0, 0, NULL),
('100054', 1, 1, 92.88, 970.00, 87.00, 0, 0, 0),
('100055', 1, 1, 138.00, 928.00, 130.00, 0, 0, 0),
('100056', 1, 1, 252.00, -12.00, 236.00, 0, 0, NULL),
('100056', 1, 1, 252.50, 1000.00, 236.00, 0, 0, 0),
('100056', 1, 1, 253.75, 1000.00, 236.00, 0, 0, 0),
('100057', 1, 1, 91.60, 996.00, 85.00, 0, 0, 0),
('100058', 1, 1, 92.00, -60.00, 87.00, 0, 0, NULL),
('100058', 1, 1, 92.88, 1000.00, 87.00, 0, 0, 0),
('100059', 1, 1, 138.00, 1052.00, 130.00, 0, 0, 0),
('100060', 1, 1, 252.00, -24.00, 236.00, 0, 0, NULL),
('100060', 1, 1, 252.50, 1000.00, 236.00, 0, 0, 0),
('100060', 1, 1, 253.00, -12.00, 236.00, 0, 0, NULL),
('100060', 1, 1, 253.75, 1000.00, 236.00, 0, 0, 0),
('100061', 1, 1, 92.00, 948.00, 87.00, 0, 0, 0),
('100062', 1, 1, 156.00, -13.00, 147.00, 0, 0, NULL),
('100062', 1, 1, 156.45, 1000.00, 147.00, 0, 0, 0),
('100063', 1, 1, 60.00, -25.00, 56.00, 0, 0, NULL),
('100063', 1, 1, 60.50, 1000.00, 56.00, 0, 0, 0),
('100064', 1, 1, 86.00, -45.00, 80.00, 0, 0, NULL),
('100064', 1, 1, 86.67, 910.00, 80.00, 0, 0, 0),
('100065', 1, 1, 113.00, -24.00, 103.00, 0, 0, NULL),
('100065', 1, 1, 113.33, 1000.00, 103.00, 0, 0, 0),
('100068', 1, 1, 100.00, 9.00, 50.00, 0, 0, 0),
('100068', 1, 1, 150.00, -10.00, 70.00, 0, 0, 0),
('100069', 1, 1, 200.00, 10.00, 70.00, 0, 0, 0),
('100069', 1, 1, 300.00, 0.00, 100.00, 0, 0, 0),
('100070', 1, 1, 100.00, 38.00, 50.00, 0, 0, 80),
('100070', 1, 1, 120.00, 16.00, 60.00, 5, 0, 90),
('100071', 1, 1, 100.00, 10.00, 50.00, 0, 0, 0),
('100071', 1, 1, 120.00, 10.00, 60.00, 0, 0, 0),
('100072', 1, 1, 100.00, 20.00, 50.00, 0, 0, 0),
('100072', 1, 1, 120.00, 10.00, 60.00, 0, 0, 0),
('100073', 1, 1, 200.00, 5.00, 100.00, 0, 0, 0),
('100074', 1, 1, 250.00, 10.00, 100.00, 0, 0, 0),
('100075', 1, 1, 100.00, -10.00, 50.00, 5, 0, 0),
('100075', 1, 1, 110.00, 5.00, 50.00, 0, 0, 0),
('100075', 1, 1, 120.00, 5.00, 60.00, 0, 0, 0),
('100076', 1, 1, 200.00, 20.00, 100.00, 0, 0, 0),
('100076', 1, 1, 220.00, 15.00, 120.00, 5, 0, 0),
('100077', 1, 1, 250.00, -20.00, 150.00, 0, 0, 0),
('100077', 1, 1, 260.00, -31.00, 160.00, 0, 0, 0),
('100077', 1, 1, 280.00, 0.00, 180.00, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductCode` varchar(50) NOT NULL,
  `Prd_Description` varchar(250) NOT NULL,
  `Prd_AppearName` varchar(250) NOT NULL,
  `Prd_Brand` smallint(6) DEFAULT NULL,
  `Prd_Quality` smallint(6) DEFAULT NULL,
  `OrgPartNo` varchar(50) DEFAULT NULL,
  `Cus_PrdCode` varchar(20) DEFAULT NULL,
  `DepCode` int(11) NOT NULL,
  `SubDepCode` int(11) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `SubCategoryCode` int(11) NOT NULL,
  `BarCode` varchar(20) NOT NULL,
  `Prd_UPC` decimal(18,2) NOT NULL,
  `Prd_UOM` smallint(6) NOT NULL,
  `Prd_ROL` decimal(18,0) DEFAULT NULL,
  `Prd_ROQ` decimal(18,0) NOT NULL,
  `Prd_Supplier` varchar(30) NOT NULL,
  `Prd_Referance` varchar(150) NOT NULL,
  `Prd_CostPrice` decimal(18,2) NOT NULL,
  `Prd_SetAPrice` decimal(18,2) DEFAULT NULL,
  `Prd_Image` longblob DEFAULT NULL,
  `Prd_IsActive` tinyint(4) NOT NULL,
  `Prd_Date` date DEFAULT NULL,
  `Prd_Rack` tinyint(4) DEFAULT 0,
  `Prd_Bin` smallint(6) DEFAULT 0,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductCode`, `Prd_Description`, `Prd_AppearName`, `Prd_Brand`, `Prd_Quality`, `OrgPartNo`, `Cus_PrdCode`, `DepCode`, `SubDepCode`, `CategoryCode`, `SubCategoryCode`, `BarCode`, `Prd_UPC`, `Prd_UOM`, `Prd_ROL`, `Prd_ROQ`, `Prd_Supplier`, `Prd_Referance`, `Prd_CostPrice`, `Prd_SetAPrice`, `Prd_Image`, `Prd_IsActive`, `Prd_Date`, `Prd_Rack`, `Prd_Bin`, `Flag`) VALUES
('100001', 'PEPSI - 1500ML', 'PEPSI - 1500ML', NULL, NULL, '-', '-', 9, 57, 0, 0, '100001', 12.00, 1, 10, 25, 'SUP0001', '', 350.50, 372.00, NULL, 1, '2025-06-25', 0, 0, NULL),
('100002', 'PEPSI - 1000ML', 'PEPSI - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100002', 12.00, 1, 0, 30, 'SUP0001', '', 250.00, 282.00, NULL, 1, '2025-06-25', 0, 0, NULL),
('100003', 'PEPSI - 750ML', 'PEPSI - 750ML', NULL, NULL, '-', '-', 7, 51, 0, 0, '100003', 12.00, 1, 0, 20, 'SUP0001', '', 191.50, 202.50, NULL, 1, '2025-07-06', 0, 0, NULL),
('100004', 'PEPSI - 2000ML', 'PEPSI - 2000ML', NULL, NULL, '-', '-', 3, 56, 0, 0, '100004', 9.00, 1, 0, 10, 'SUP0001', '', 423.00, 448.56, NULL, 1, '2025-07-07', 0, 0, NULL),
('100005', 'PEPSI - 400ML', 'PEPSI - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100005', 24.00, 1, 0, 15, 'SUP0001', '', 155.54, 164.00, NULL, 1, '2025-07-07', 0, 0, NULL),
('100006', 'PEPSI - 300ML', 'PEPSI - 300ML', NULL, NULL, '-', '-', 5, 58, 0, 0, '100006', 24.00, 1, 0, 15, 'SUP0001', '', 100.58, 108.75, NULL, 1, '2025-07-07', 0, 0, NULL),
('100007', 'PEPSI - 250ML', 'PEPSI - 250ML', NULL, NULL, '-', '-', 4, 54, 0, 0, '100007', 24.00, 1, 0, 25, 'SUP0001', '', 104.29, 111.46, NULL, 1, '2025-07-07', 0, 0, NULL),
('100008', 'PEPSI - 200ML', 'PEPSI - 200ML', NULL, NULL, '-', '-', 1, 55, 0, 0, '100008', 24.00, 1, 0, 50, 'SUP0002', '', 85.00, 91.60, NULL, 1, '2025-07-07', 0, 0, NULL),
('100009', '7UP - 200ML', '7UP - 200ML', NULL, NULL, '-', '-', 1, 55, 0, 0, '100009', 24.00, 1, 0, 50, 'SUP0002', '', 85.00, 91.60, NULL, 1, '2025-07-07', 0, 0, NULL),
('100010', '7UP - 250ML', '7UP - 250ML', NULL, NULL, '-', '-', 4, 54, 0, 0, '100010', 24.00, 1, 0, 25, 'SUP0001', '', 104.29, 111.46, NULL, 1, '2025-07-08', 0, 0, NULL),
('100011', '7UP - 300ML', '7UP - 300ML', NULL, NULL, '-', '-', 5, 58, 0, 0, '100011', 24.00, 1, 0, 15, 'SUP0001', '', 100.58, 108.75, NULL, 1, '2025-07-08', 0, 0, NULL),
('100012', '7UP - 400ML', '7UP - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100012', 24.00, 1, 0, 15, 'SUP0001', '', 155.54, 164.00, NULL, 1, '2025-07-08', 0, 0, NULL),
('100013', '7UP - 750ML', '7UP - 750ML', NULL, NULL, '-', '-', 7, 51, 0, 0, '100013', 12.00, 1, 0, 15, 'SUP0001', '', 191.50, 202.50, NULL, 1, '2025-07-08', 0, 0, NULL),
('100014', '7UP - 1000ML', '7UP - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100014', 12.00, 1, 0, 25, 'SUP0001', '', 263.50, 282.00, NULL, 1, '2025-07-08', 0, 0, NULL),
('100015', '7UP - 1500ML', '7UP - 1500ML', NULL, NULL, '-', '-', 9, 52, 0, 0, '100015', 10.00, 1, 0, 20, 'SUP0001', '', 350.50, 372.00, NULL, 1, '2025-07-08', 0, 0, NULL),
('100016', '7UP - 2000ML', '7UP - 2000ML', NULL, NULL, '-', '-', 3, 56, 0, 0, '100016', 9.00, 1, 0, 10, 'SUP0001', '', 422.78, 448.56, NULL, 1, '2025-07-09', 0, 0, NULL),
('100017', 'MIRINDA - 200ML', 'MIRINDA - 200ML', NULL, NULL, '-', '-', 1, 55, 0, 0, '100017', 24.00, 1, 0, 15, 'SUP0002', '', 85.00, 91.60, NULL, 1, '2025-07-09', 0, 0, NULL),
('100018', 'MIRINDA - 250ML', 'MIRINDA - 250ML', NULL, NULL, '-', '-', 4, 54, 0, 0, '100018', 24.00, 1, 0, 15, 'SUP0001', '', 104.29, 111.46, NULL, 1, '2025-07-09', 0, 0, NULL),
('100019', 'MIRINDA - 300ML', 'MIRINDA - 300ML', NULL, NULL, '-', '-', 5, 58, 0, 0, '100019', 24.00, 1, 0, 5, 'SUP0001', '', 100.58, 108.75, NULL, 1, '2025-07-09', 0, 0, NULL),
('100020', 'MIRINDA - 400ML', 'MIRINDA - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100020', 24.00, 1, 0, 5, 'SUP0001', '', 155.54, 187.25, NULL, 1, '2025-07-09', 0, 0, NULL),
('100021', 'MIRINDA - 750ML', 'MIRINDA - 750ML', NULL, NULL, '-', '-', 7, 51, 0, 0, '100021', 12.00, 1, 0, 15, 'SUP0001', '', 176.68, 186.67, NULL, 1, '2025-07-09', 0, 0, NULL),
('100022', 'MIRINDA - 1000ML', 'MIRINDA - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100022', 12.00, 1, 0, 15, 'SUP0001', '', 263.50, 282.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100023', 'MIRINDA - 1500ML', 'MIRINDA - 1500ML', NULL, NULL, '-', '-', 9, 52, 0, 0, '100023', 12.00, 1, 0, 10, 'SUP0001', '', 350.50, 372.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100024', 'MIRINDA - 2000ML', 'MIRINDA - 2000ML', NULL, NULL, '-', '-', 3, 56, 0, 0, '100024', 9.00, 1, 0, 5, 'SUP0001', '', 422.78, 448.56, NULL, 1, '2025-07-09', 0, 0, NULL),
('100025', 'MONTAN DEW - 200ML', 'MONTAN DEW - 200ML', NULL, NULL, '-', '-', 1, 55, 0, 0, '100025', 24.00, 1, 5, 5, 'SUP0002', '', 85.00, 91.60, NULL, 1, '2025-07-09', 0, 0, NULL),
('100026', 'MONTAN DEW - 250ML', 'MONTAN DEW - 250ML', NULL, NULL, '-', '-', 4, 54, 0, 0, '100026', 24.00, 1, 0, 5, 'SUP0001', '', 104.29, 111.46, NULL, 1, '2025-07-09', 0, 0, NULL),
('100027', 'MONTAN DEW - 400ML', 'MONTAN DEW - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100027', 24.00, 1, 0, 5, 'SUP0001', '', 155.54, 164.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100028', 'MONTAN DEW - 750ML', 'MONTAN DEW - 750ML', NULL, NULL, '-', '-', 7, 51, 0, 0, '100028', 12.00, 1, 0, 10, 'SUP0001', '', 191.50, 202.50, NULL, 1, '2025-07-09', 0, 0, NULL),
('100029', 'MONTAN DEW - 1500ML', 'MONTAN DEW - 1500ML', NULL, NULL, '-', '-', 9, 52, 0, 0, '100029', 12.00, 1, 0, 5, 'SUP0001', '', 350.50, 372.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100030', 'TEST_PRO_1', 'TEST_PRO_1', NULL, NULL, '-', '-', 11, 45, 0, 0, '100030', 10.00, 1, 10, 10, 'SUP0012', '', 100.00, 120.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100031', 'TEST_PRO_2', 'TEST_PRO_2', NULL, NULL, '-', '-', 12, 48, 0, 0, '100031', 12.00, 1, 5, 5, 'SUP0012', '', 150.00, 180.00, NULL, 1, '2025-07-09', 0, 0, NULL),
('100032', 'PROABC', 'PROABC', NULL, NULL, '-', '-', 13, 49, 0, 0, '100032', 10.00, 1, 10, 10, 'SUP0012', '', 100.00, 150.00, NULL, 1, '2025-07-16', 0, 0, NULL),
('100033', 'TEST PRODUCT 1245', 'TEST PRODUCT 1245', NULL, NULL, '-', '-', 11, 45, 0, 0, '100033', 12.00, 1, 10, 5, 'SUP0014', '', 100.00, 120.00, NULL, 1, '2025-07-18', 0, 0, NULL),
('100034', 'P2', 'P2', NULL, NULL, '-', '-', 13, 49, 0, 0, '100034', 10.00, 1, 5, 5, 'SUP0014', '', 20.00, 50.00, NULL, 1, '2025-07-18', 0, 0, NULL),
('100035', 'P1', 'P1', NULL, NULL, '-', '-', 13, 49, 0, 0, '100035', 10.00, 1, 5, 5, 'SUP0014', '', 130.00, 150.00, NULL, 1, '2025-07-18', 0, 0, NULL),
('100036', 'P3', 'P3', NULL, NULL, '-', '-', 15, 60, 0, 0, '100036', 10.00, 1, 5, 5, 'SUP0017', '', 400.00, 500.00, NULL, 1, '2025-07-21', 0, 0, NULL),
('100037', 'APPLE DRINK', 'APPLE DRINK', NULL, NULL, '-', '-', 16, 61, 0, 0, '100037', 1.00, 1, 1, 1, 'SUP0018', '', 450.00, 500.00, NULL, 1, '2025-07-23', 0, 0, NULL),
('100038', 'WATER', 'WATER', NULL, NULL, '-', '-', 16, 61, 0, 0, '100038', 1.00, 1, 1, 1, 'SUP0014', '', 100.00, 200.00, NULL, 1, '2025-07-24', 0, 0, NULL),
('100039', 'TEST_ITM1', 'TEST_ITM1', NULL, NULL, '-', '-', 13, 49, 0, 0, '100039', 10.00, 1, 10, 10, 'SUP0017', '', 100.00, 120.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100040', 'TEST_ITM2', 'TEST_ITM2', NULL, NULL, '-', '-', 13, 49, 0, 0, '100040', 10.00, 1, 10, 10, 'SUP0017', '', 150.00, 180.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100041', 'TEST_ITM3', 'TEST_ITM3', NULL, NULL, '-', '-', 13, 49, 0, 0, '100041', 10.00, 1, 10, 10, 'SUP0017', '', 200.00, 210.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100042', 'PRO_NEW_1', 'PRO_NEW_1', NULL, NULL, '-', '-', 17, 63, 0, 0, '100042', 10.00, 1, 10, 10, 'SUP0019', '', 120.00, 120.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100043', 'PRO_NEW_2', 'PRO_NEW_2', NULL, NULL, '-', '-', 17, 63, 0, 0, '100043', 12.00, 1, 12, 12, 'SUP0019', '', 160.00, 180.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100044', 'PRO_NEW_3', 'PRO_NEW_3', NULL, NULL, '-', '-', 17, 63, 0, 0, '100044', 10.00, 1, 5, 5, 'SUP0019', '', 200.00, 250.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100045', 'TEST-IT1', 'TEST-IT1', NULL, NULL, '.', '.', 13, 49, 0, 0, '100045', 5.00, 1, 10, 10, 'SUP0001', '', 100.00, 110.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100046', 'T1', 'T1', NULL, NULL, '-', '-', 13, 49, 0, 0, '100046', 10.00, 1, 10, 10, 'SUP0001', '', 120.00, 150.00, NULL, 1, '2025-07-30', 0, 0, NULL),
('100047', 'P01', 'P01', NULL, NULL, '-', '-', 1, 1, 0, 0, '100047', 12.00, 1, 5, 5, 'SUP0014', '', 100.00, 120.00, NULL, 1, '2025-08-12', 0, 0, NULL),
('100048', 'CREAM SODA - 200ML', 'CREAM SODA - 200ML', NULL, NULL, '-', '-', 1, 1, 0, 0, '100048', 1.00, 1, 1, 1, 'SUP0013', '', 85.00, 91.60, NULL, 1, '2025-08-13', 0, 0, NULL),
('100049', 'CREAM SODA - 250ML', 'CREAM SODA - 250ML', NULL, NULL, '-', '-', 4, 23, 0, 0, '100049', 1.00, 1, 1, 1, 'SUP0013', '', 87.00, 92.88, NULL, 1, '2025-08-13', 0, 0, NULL),
('100050', 'CREAM SODA - 400ML', 'CREAM SODA - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100050', 1.00, 1, 1, 1, '0', '', 130.00, 138.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100051', 'CREAM SODA - 1000ML', 'CREAM SODA - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100051', 1.00, 1, 1, 1, 'SUP0013', '', 236.00, 253.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100052', 'CREAM SODA - 1500ML', 'CREAM SODA - 1500ML', NULL, NULL, '-', '-', 9, 52, 0, 0, '100052', 1.00, 1, 1, 1, 'SUP0013', '', 341.00, 361.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100053', 'GINGER BEER - 200ML', 'GINGER BEER - 200ML', NULL, NULL, '-', '=', 1, 1, 0, 0, '100053', 1.00, 1, 1, 1, 'SUP0013', '', 85.00, 91.60, NULL, 1, '2025-08-13', 0, 0, NULL),
('100054', 'GINGER BEER - 250ML', 'GINGER BEER - 250ML', NULL, NULL, '-', '-', 4, 23, 0, 0, '100054', 1.00, 1, 1, 1, 'SUP0013', '', 87.00, 92.88, NULL, 1, '2025-08-13', 0, 0, NULL),
('100055', 'GINGER BEER - 400ML', 'GINGER BEER - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100055', 1.00, 1, 1, 1, 'SUP0013', '', 130.00, 138.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100056', 'GINGER BEER - 1000ML', 'GINGER BEER - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100056', 1.00, 1, 1, 1, 'SUP0013', '', 236.00, 253.75, NULL, 1, '2025-08-13', 0, 0, NULL),
('100057', 'ZINGO - 200ML', 'ZINGO - 200ML', NULL, NULL, '-', '=', 1, 1, 0, 0, '100057', 1.00, 1, 1, 1, 'SUP0013', '', 85.00, 91.60, NULL, 1, '2025-08-13', 0, 0, NULL),
('100058', 'ZINGO - 250ML', 'ZINGO - 250ML', NULL, NULL, '-', '-', 4, 23, 0, 0, '100058', 1.00, 1, 1, 1, 'SUP0013', '', 87.00, 92.88, NULL, 1, '2025-08-13', 0, 0, NULL),
('100059', 'ZINGO - 400ML', 'ZINGO - 400ML', NULL, NULL, '-', '-', 2, 64, 0, 0, '100059', 1.00, 1, 1, 1, 'SUP0013', '', 130.00, 138.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100060', 'ZINGO - 1000ML', 'ZINGO - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100060', 1.00, 1, 1, 1, 'SUP0013', '', 236.00, 253.75, NULL, 1, '2025-08-13', 0, 0, NULL),
('100061', 'SODA (EV) - 400ML', 'SODA (EV) - 400ML', NULL, NULL, '-', '=', 2, 64, 0, 0, '100061', 1.00, 1, 1, 1, 'SUP0013', '', 87.00, 92.00, NULL, 1, '2025-08-13', 0, 0, NULL),
('100062', 'SODA (EV) - 1000ML', 'SODA (EV) - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100062', 1.00, 1, 1, 1, 'SUP0013', '', 147.00, 156.45, NULL, 1, '2025-08-13', 0, 0, NULL),
('100063', 'WATER - 500ML', 'WATER - 500ML', NULL, NULL, '-', '=', 10, 43, 0, 0, '100063', 1.00, 1, 1, 1, 'SUP0013', '', 56.00, 60.50, NULL, 1, '2025-08-13', 0, 0, NULL),
('100064', 'WATER - 1000ML', 'WATER - 1000ML', NULL, NULL, '-', '-', 8, 50, 0, 0, '100064', 1.00, 1, 1, 1, 'SUP0013', '', 80.00, 86.67, NULL, 1, '2025-08-13', 0, 0, NULL),
('100065', 'WATER - 1500ML', 'WATER - 1500ML', NULL, NULL, '-', '-', 9, 52, 0, 0, '100065', 1.00, 1, 1, 1, 'SUP0013', '', 103.00, 113.33, NULL, 1, '2025-08-13', 0, 0, NULL),
('100066', 'STING 200 ML', 'STING 200 ML', NULL, NULL, '-', '-', 1, 1, 0, 0, '100066', 1.00, 1, 1, 1, 'SUP0013', '', 85.00, 91.60, NULL, 1, '2025-08-13', 0, 0, NULL),
('100067', 'STING 250 ML', 'STING 250 ML', NULL, NULL, '-', '-', 4, 23, 0, 0, '100067', 1.00, 1, 1, 1, 'SUP0013', '', 105.00, 111.46, NULL, 1, '2025-08-13', 0, 0, NULL),
('100068', 'APPLE', 'APPLE', NULL, NULL, '-', '-', 17, 63, 0, 0, '100068', 1.00, 1, 5, 5, 'SUP0014', '', 70.00, 100.00, NULL, 1, '2025-08-21', 0, 0, NULL),
('100069', 'APPLE 2', 'APPLE 2', NULL, NULL, '-', '-', 17, 63, 0, 0, '100069', 1.00, 1, 5, 5, 'SUP0014', '', 100.00, 200.00, NULL, 1, '2025-08-21', 0, 0, NULL),
('100070', 'ORANGE CRUSH', 'ORANGE CRUSH', NULL, NULL, '-', '-', 1, 1, 0, 0, '100070', 5.00, 1, 5, 5, 'SUP0021', '', 60.00, 100.00, NULL, 1, '2025-08-28', 0, 0, NULL),
('100071', 'PAPAYA', 'PAPAYA', NULL, NULL, '-', '-', 1, 1, 0, 0, '100071', 1.00, 1, 1, 1, 'SUP0021', '', 60.00, 100.00, NULL, 1, '2025-08-30', 0, 0, NULL),
('100072', 'PINEAPPLE', 'PINEAPPLE', NULL, NULL, '-', '-', 1, 1, 0, 0, '100072', 1.00, 1, 1, 1, 'SUP0012', '', 60.00, 100.00, NULL, 1, '2025-08-30', 0, 0, NULL),
('100073', 'GRAPES', 'GRAPES', NULL, NULL, '-', '-', 1, 5, 0, 0, '100073', 1.00, 1, 1, 1, 'SUP0012', '', 100.00, 200.00, NULL, 1, '2025-08-30', 0, 0, NULL),
('100074', 'PEARS', 'PEARS', NULL, NULL, '-', '-', 1, 5, 0, 0, '100074', 1.00, 1, 1, 1, 'SUP0012', '', 100.00, 250.00, NULL, 1, '2025-08-30', 0, 0, NULL),
('100075', 'BANANA', 'BANANA', NULL, NULL, '-', '-', 1, 1, 0, 0, '100075', 1.00, 1, 1, 1, 'SUP0021', '', 50.00, 100.00, NULL, 1, '2025-09-01', 0, 0, NULL),
('100076', 'AVACADO', 'AVACADO', NULL, NULL, '-', '-', 1, 1, 0, 0, '100076', 1.00, 1, 1, 1, 'SUP0021', '', 120.00, 200.00, NULL, 1, '2025-09-01', 0, 0, NULL),
('100077', 'GUAVA', 'GUAVA', NULL, NULL, '-', '-', 1, 1, 0, 0, '100077', 1.00, 1, 1, 1, 'SUP0021', '', 180.00, 250.00, NULL, 1, '2025-09-01', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productbrand`
--

CREATE TABLE `productbrand` (
  `BrandID` smallint(6) NOT NULL,
  `BrandName` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productcategory`
--

CREATE TABLE `productcategory` (
  `ProductCode` varchar(18) NOT NULL,
  `DepCode` smallint(6) NOT NULL,
  `SubDepCode` smallint(6) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `SubCategoryCode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productcondition`
--

CREATE TABLE `productcondition` (
  `ProductCode` varchar(28) NOT NULL,
  `IsOpenPrice` tinyint(4) NOT NULL,
  `IsFraction` tinyint(4) NOT NULL,
  `IsDiscount` tinyint(4) NOT NULL,
  `IsMultiPrice` tinyint(4) NOT NULL,
  `IsSerial` tinyint(4) NOT NULL,
  `IsPromotions` tinyint(4) NOT NULL,
  `IsTax` tinyint(4) NOT NULL,
  `IsNbt` tinyint(4) NOT NULL,
  `NbtRatio` decimal(5,2) DEFAULT 1.00,
  `IsFreeIssue` tinyint(4) NOT NULL,
  `IsWarranty` tinyint(4) NOT NULL,
  `WarrantyPeriod` decimal(18,0) NOT NULL,
  `DiscountLimit` decimal(18,2) NOT NULL,
  `IsRawMaterial` tinyint(4) DEFAULT NULL,
  `IsCostDisMargin` tinyint(4) DEFAULT NULL,
  `CostDisPercentage` decimal(18,2) DEFAULT NULL,
  `IsService` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `productcondition`
--

INSERT INTO `productcondition` (`ProductCode`, `IsOpenPrice`, `IsFraction`, `IsDiscount`, `IsMultiPrice`, `IsSerial`, `IsPromotions`, `IsTax`, `IsNbt`, `NbtRatio`, `IsFreeIssue`, `IsWarranty`, `WarrantyPeriod`, `DiscountLimit`, `IsRawMaterial`, `IsCostDisMargin`, `CostDisPercentage`, `IsService`) VALUES
('100001', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100002', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100003', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100004', 0, 0, 1, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 15.00, 0, 0, NULL, NULL),
('100005', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100006', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100007', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100008', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100009', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100010', 0, 0, 1, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 13.00, 0, 0, NULL, NULL),
('100011', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100012', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100013', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100014', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100015', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100016', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100017', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100018', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100019', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100020', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100021', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100022', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100023', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100024', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100025', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100026', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100027', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100028', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100029', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100030', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100031', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100032', 1, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100033', 0, 0, 1, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 10.00, 0, 0, NULL, NULL),
('100034', 0, 0, 1, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 100.00, 0, 0, NULL, NULL),
('100035', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100036', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100037', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100038', 0, 0, 1, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 10.00, 0, 0, NULL, NULL),
('100039', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100040', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100041', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100042', 1, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100043', 1, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100044', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100045', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100046', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100047', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100048', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100049', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100050', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100051', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100052', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100053', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100054', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100055', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100056', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100057', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100058', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100059', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100060', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100061', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100062', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100063', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100064', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100065', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100066', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100067', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100068', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100069', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100070', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100071', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100072', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100073', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100074', 0, 0, 0, 0, 0, 0, 0, 0, 1.00, 0, 0, 0, 0.00, 0, 0, NULL, NULL),
('100075', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100076', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL),
('100077', 0, 0, 0, 1, 0, 0, 0, 0, 1.00, 1, 0, 0, 0.00, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productlocation`
--

CREATE TABLE `productlocation` (
  `ProductCode` varchar(28) NOT NULL,
  `ProLocation` smallint(6) NOT NULL,
  `ProRack` smallint(6) NOT NULL,
  `ProBin` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productprice`
--

CREATE TABLE `productprice` (
  `ProductCode` varchar(28) NOT NULL,
  `PL_No` smallint(6) NOT NULL,
  `ProductPrice` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `productprice`
--

INSERT INTO `productprice` (`ProductCode`, `PL_No`, `ProductPrice`) VALUES
('100001', 1, 372.00),
('100002', 1, 282.00),
('100003', 1, 202.50),
('100004', 1, 448.56),
('100005', 1, 187.25),
('100006', 1, 108.75),
('100007', 1, 111.46),
('100008', 1, 91.60),
('100009', 1, 91.60),
('100010', 1, 111.46),
('100011', 1, 108.75),
('100012', 1, 187.25),
('100013', 1, 202.50),
('100014', 1, 282.00),
('100015', 1, 372.00),
('100016', 1, 448.56),
('100017', 1, 91.60),
('100018', 1, 111.46),
('100019', 1, 108.75),
('100020', 1, 165.00),
('100021', 1, 186.67),
('100022', 1, 282.00),
('100023', 1, 372.00),
('100024', 1, 448.56),
('100025', 1, 91.60),
('100026', 1, 111.46),
('100027', 1, 187.25),
('100028', 1, 202.50),
('100029', 1, 372.00),
('100030', 1, 120.00),
('100031', 1, 180.00),
('100032', 1, 160.00),
('100034', 1, 50.00),
('100035', 1, 180.00),
('100036', 1, 500.00),
('100037', 1, 500.00),
('100037', 2, 400.00),
('100038', 1, 200.00),
('100038', 2, 150.00),
('100039', 1, 130.00),
('100040', 1, 180.00),
('100041', 1, 210.00),
('100042', 1, 130.00),
('100043', 1, 200.00),
('100044', 1, 250.00),
('100045', 1, 110.00),
('100046', 1, 150.00),
('100047', 1, 130.00),
('100048', 1, 91.60),
('100049', 1, 92.88),
('100050', 1, 138.00),
('100051', 1, 253.75),
('100052', 1, 361.00),
('100053', 1, 91.60),
('100054', 1, 92.88),
('100055', 1, 138.00),
('100056', 1, 253.75),
('100057', 1, 91.60),
('100058', 1, 92.88),
('100059', 1, 138.00),
('100060', 1, 253.75),
('100061', 1, 92.00),
('100062', 1, 156.45),
('100063', 1, 60.50),
('100064', 1, 86.67),
('100065', 1, 113.33),
('100066', 1, 91.60),
('100067', 1, 111.46),
('100068', 1, 150.00),
('100069', 1, 300.00),
('100070', 1, 120.00),
('100070', 2, 90.00),
('100071', 1, 120.00),
('100072', 1, 120.00),
('100073', 1, 200.00),
('100074', 1, 250.00),
('100075', 1, 110.00),
('100076', 1, 200.00),
('100077', 1, 280.00);

-- --------------------------------------------------------

--
-- Table structure for table `productqtywisepricegroup`
--

CREATE TABLE `productqtywisepricegroup` (
  `MaxNo` int(11) NOT NULL,
  `ProductCode` varchar(20) NOT NULL,
  `FromQty` decimal(18,2) NOT NULL,
  `ToQty` decimal(18,2) NOT NULL,
  `SetPrice` decimal(18,2) NOT NULL,
  `SetDiscount` decimal(18,2) NOT NULL,
  `FreeQty` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productquality`
--

CREATE TABLE `productquality` (
  `QualityID` smallint(6) NOT NULL,
  `QualityName` varchar(50) DEFAULT NULL,
  `ShortName` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productserialstock`
--

CREATE TABLE `productserialstock` (
  `ProductCode` varchar(20) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `SerialNo` varchar(30) NOT NULL,
  `Quantity` decimal(18,0) NOT NULL,
  `GrnNo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productstock`
--

CREATE TABLE `productstock` (
  `ProductCode` varchar(20) NOT NULL,
  `Location` smallint(6) NOT NULL,
  `Stock` decimal(18,2) NOT NULL,
  `OpenStock` decimal(18,2) NOT NULL,
  `Flag` tinyint(4) NOT NULL,
  `Damage` int(11) DEFAULT NULL,
  `Expired` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `productstock`
--

INSERT INTO `productstock` (`ProductCode`, `Location`, `Stock`, `OpenStock`, `Flag`, `Damage`, `Expired`) VALUES
('100001', 1, 923.00, 0.00, 0, NULL, 5),
('100002', 1, 910.00, 0.00, 0, 3, NULL),
('100004', 1, 947.00, 0.00, 0, 2, NULL),
('100005', 1, 858.00, 0.00, 0, NULL, 1),
('100007', 1, 745.00, 0.00, 0, 1, 1),
('100008', 1, 1230.00, 0.00, 0, 1, NULL),
('100009', 1, 624.00, 0.00, 0, 10, 2),
('100010', 1, 889.00, 0.00, 0, 1, 10),
('100012', 1, 928.00, 0.00, 0, NULL, NULL),
('100014', 1, 899.00, 0.00, 0, NULL, 2),
('100015', 1, 915.00, 0.00, 0, NULL, NULL),
('100016', 1, 964.00, 0.00, 0, NULL, NULL),
('100017', 1, 834.00, 0.00, 0, NULL, NULL),
('100018', 1, 910.00, 0.00, 0, NULL, NULL),
('100020', 1, 904.00, 0.00, 0, 1, NULL),
('100022', 1, 917.00, 0.00, 0, NULL, NULL),
('100023', 1, 970.00, 0.00, 0, NULL, NULL),
('100024', 1, 973.00, 0.00, 0, NULL, NULL),
('100025', 1, 965.00, 0.00, 0, NULL, NULL),
('100026', 1, 929.00, 0.00, 0, NULL, 1),
('100027', 1, 1000.00, 0.00, 0, NULL, NULL),
('100029', 1, 988.00, 0.00, 0, NULL, NULL),
('100047', 1, 99.00, 0.00, 0, 10, NULL),
('100048', 1, 976.00, 0.00, 0, 2, NULL),
('100049', 1, 869.00, 0.00, 0, NULL, NULL),
('100050', 1, 951.00, 0.00, 0, NULL, NULL),
('100051', 1, 1920.00, 0.00, 0, NULL, NULL),
('100052', 1, 980.00, 0.00, 0, NULL, NULL),
('100053', 1, 967.00, 0.00, 0, 1, NULL),
('100054', 1, 899.00, 0.00, 0, NULL, NULL),
('100055', 1, 928.00, 0.00, 0, NULL, NULL),
('100056', 1, 1988.00, 0.00, 0, NULL, NULL),
('100057', 1, 996.00, 0.00, 0, NULL, NULL),
('100058', 1, 940.00, 0.00, 0, NULL, NULL),
('100059', 1, 1052.00, 0.00, 0, NULL, NULL),
('100060', 1, 1964.00, 0.00, 0, NULL, NULL),
('100061', 1, 948.00, 0.00, 0, NULL, NULL),
('100062', 1, 987.00, 0.00, 0, NULL, NULL),
('100063', 1, 975.00, 0.00, 0, NULL, NULL),
('100064', 1, 865.00, 0.00, 0, NULL, NULL),
('100065', 1, 976.00, 0.00, 0, NULL, NULL),
('100068', 1, -1.00, 0.00, 0, NULL, NULL),
('100069', 1, 10.00, 0.00, 0, NULL, NULL),
('100070', 1, 54.00, 0.00, 0, 5, NULL),
('100071', 1, 20.00, 0.00, 0, NULL, NULL),
('100072', 1, 30.00, 0.00, 0, NULL, NULL),
('100073', 1, 5.00, 0.00, 0, NULL, NULL),
('100074', 1, 10.00, 0.00, 0, NULL, NULL),
('100075', 1, 0.00, 0.00, 0, 5, NULL),
('100076', 1, 35.00, 0.00, 0, 5, NULL),
('100077', 1, -51.00, 0.00, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `producttempstock`
--

CREATE TABLE `producttempstock` (
  `id` int(11) NOT NULL,
  `productCode` varchar(45) NOT NULL,
  `stock` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `psPriceLavel` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `Price` decimal(20,6) NOT NULL DEFAULT 0.000000
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `public_preferences`
--

CREATE TABLE `public_preferences` (
  `id` int(11) NOT NULL,
  `transition_page` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `public_preferences`
--

INSERT INTO `public_preferences` (`id`, `transition_page`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdtl`
--

CREATE TABLE `purchaseorderdtl` (
  `PO_Id` int(11) NOT NULL,
  `AppNo` int(11) NOT NULL,
  `PO_No` varchar(8) NOT NULL,
  `ProductCode` varchar(18) NOT NULL,
  `PO_ProName` varchar(100) DEFAULT NULL,
  `PO_UPC` decimal(18,0) NOT NULL,
  `PO_Type` varchar(10) NOT NULL,
  `PO_UnitCost` decimal(18,2) NOT NULL,
  `PO_UnitPrice` decimal(10,2) DEFAULT 0.00,
  `PO_CaseCost` decimal(18,2) NOT NULL,
  `PO_DisPercentage` decimal(18,2) NOT NULL,
  `PO_DisAmount` decimal(18,2) NOT NULL,
  `PO_Qty` decimal(18,2) NOT NULL,
  `PO_TotalQty` decimal(18,2) NOT NULL,
  `GRN_Qty` decimal(18,2) NOT NULL,
  `PO_IsVat` tinyint(1) DEFAULT 0,
  `PO_IsNbt` tinyint(1) DEFAULT 0,
  `PO_NbtRatio` decimal(5,2) DEFAULT 0.00,
  `PO_VatAmount` decimal(18,2) DEFAULT NULL,
  `PO_NbtAmount` decimal(18,2) DEFAULT NULL,
  `PO_TotalAmount` decimal(18,2) NOT NULL,
  `PO_NetAmount` decimal(18,2) NOT NULL,
  `PO_LineNo` smallint(6) NOT NULL,
  `PO_IsComplete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderhed`
--

CREATE TABLE `purchaseorderhed` (
  `AppNo` int(11) NOT NULL,
  `PO_No` varchar(8) NOT NULL,
  `QuotationNo` varchar(8) NOT NULL,
  `PO_Location` smallint(6) NOT NULL,
  `PO_Bil` varchar(20) DEFAULT NULL,
  `JobNo` varchar(10) DEFAULT NULL,
  `PO_Date` datetime NOT NULL,
  `PO_DeleveryDate` datetime NOT NULL,
  `SupCode` varchar(8) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `PO_IsNbtTotal` tinyint(1) DEFAULT 0,
  `PO_IsVatTotal` tinyint(1) DEFAULT 0,
  `PO_NbtRatioTotal` decimal(5,2) DEFAULT NULL,
  `PONbtAmount` decimal(18,2) DEFAULT NULL,
  `POVatAmount` decimal(18,2) DEFAULT NULL,
  `PO_TDisPercentage` decimal(18,2) NOT NULL,
  `PO_TDisAmount` decimal(18,2) NOT NULL,
  `PO_Amount` decimal(18,2) NOT NULL,
  `PO_NetAmount` decimal(18,2) NOT NULL,
  `PO_User` varchar(15) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsComplate` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchasereturnnotedtl`
--

CREATE TABLE `purchasereturnnotedtl` (
  `AppNo` int(11) NOT NULL,
  `PRN_No` varchar(8) NOT NULL,
  `PRN_Product` varchar(18) NOT NULL,
  `PRN_UPCType` varchar(6) NOT NULL,
  `PRN_UPC` decimal(18,0) NOT NULL,
  `PRN_Qty` decimal(18,2) NOT NULL,
  `PRN_UnitCost` decimal(18,2) NOT NULL,
  `PRN_PriceLevel` smallint(6) NOT NULL,
  `PRN_Selling` decimal(18,2) NOT NULL,
  `PRN_Amount` decimal(18,2) NOT NULL,
  `IsSerial` tinyint(4) NOT NULL,
  `Serial` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchasereturnnotedtl`
--

INSERT INTO `purchasereturnnotedtl` (`AppNo`, `PRN_No`, `PRN_Product`, `PRN_UPCType`, `PRN_UPC`, `PRN_Qty`, `PRN_UnitCost`, `PRN_PriceLevel`, `PRN_Selling`, `PRN_Amount`, `IsSerial`, `Serial`) VALUES
(1, 'PRN0007', '100072', 'UNIT', 1, 5.00, 50.00, 1, 100.00, 250.00, 0, ''),
(1, 'PRN0008', '100075', 'UNIT', 1, 10.00, 70.00, 1, 110.00, 700.00, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `purchasereturnnotehed`
--

CREATE TABLE `purchasereturnnotehed` (
  `AppNo` int(11) NOT NULL,
  `PRN_No` varchar(8) NOT NULL,
  `PRN_Date` datetime NOT NULL,
  `PRN_DateORG` datetime NOT NULL,
  `PRN_Location` smallint(6) NOT NULL,
  `PRN_SupCode` varchar(8) NOT NULL,
  `GRN_No` varchar(10) NOT NULL,
  `PRN_Remark` varchar(150) NOT NULL,
  `PRN_Cost_Amount` decimal(18,2) NOT NULL,
  `PRN_User` varchar(20) NOT NULL,
  `PRN_IsCancel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `purchasereturnnotehed`
--

INSERT INTO `purchasereturnnotehed` (`AppNo`, `PRN_No`, `PRN_Date`, `PRN_DateORG`, `PRN_Location`, `PRN_SupCode`, `GRN_No`, `PRN_Remark`, `PRN_Cost_Amount`, `PRN_User`, `PRN_IsCancel`) VALUES
(1, 'PRN0007', '2025-08-30 00:00:00', '2025-08-30 15:01:50', 1, '0', '0', '', 250.00, '1', 0),
(1, 'PRN0008', '2025-09-02 00:00:00', '2025-09-02 11:18:31', 1, '0', '0', '', 700.00, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rack`
--

CREATE TABLE `rack` (
  `rack_id` smallint(6) NOT NULL,
  `rack_no` varchar(50) DEFAULT NULL,
  `rack_loc` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rack`
--

INSERT INTO `rack` (`rack_id`, `rack_no`, `rack_loc`) VALUES
(1, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `received_invoices`
--

CREATE TABLE `received_invoices` (
  `id` int(11) NOT NULL,
  `InvoiceNo` varchar(50) NOT NULL,
  `ReceivedDate` date NOT NULL,
  `ReceivedRemark` text DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `SalespersonID` varchar(11) DEFAULT NULL,
  `Route` varchar(100) DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `received_invoices_items`
--

CREATE TABLE `received_invoices_items` (
  `id` int(11) NOT NULL,
  `InvoiceID` int(11) NOT NULL,
  `ProductCode` varchar(50) NOT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `Quantity` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_extra_amount`
--

CREATE TABLE `rental_extra_amount` (
  `AccNo` varchar(20) NOT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `PayDate` date NOT NULL DEFAULT '0000-00-00',
  `PayDesc` varchar(100) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `ExtraNo` tinyint(4) NOT NULL DEFAULT 0,
  `IsPaid` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_paid`
--

CREATE TABLE `rental_paid` (
  `PaymentId` varchar(20) NOT NULL,
  `PaymentType` int(11) NOT NULL DEFAULT 0,
  `TotalPayment` decimal(20,2) DEFAULT NULL,
  `CashPayment` decimal(20,2) DEFAULT NULL,
  `ChequePayment` decimal(20,2) DEFAULT NULL,
  `PayAmount` decimal(20,2) DEFAULT NULL,
  `AccNo` varchar(20) DEFAULT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `CusCode` varchar(10) DEFAULT NULL,
  `PayDate` date DEFAULT NULL,
  `ChequeNo` varchar(50) DEFAULT NULL,
  `ChequeRecDate` date DEFAULT NULL,
  `ChequeDate` date DEFAULT NULL,
  `ChequeReference` varchar(100) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `InsuranceAmount` decimal(20,2) DEFAULT NULL,
  `InvDate` datetime DEFAULT NULL,
  `IsCancel` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_paid_dtl`
--

CREATE TABLE `rental_paid_dtl` (
  `PaymentId` varchar(20) NOT NULL,
  `PaymentType` int(11) NOT NULL DEFAULT 0,
  `PayAmount` decimal(20,2) DEFAULT NULL,
  `InvNo` varchar(20) NOT NULL DEFAULT '',
  `AccNo` varchar(20) DEFAULT NULL,
  `Month` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rental_payment_dtl`
--

CREATE TABLE `rental_payment_dtl` (
  `AccNo` varchar(20) NOT NULL,
  `InvNo` varchar(20) DEFAULT '',
  `Month` int(11) NOT NULL DEFAULT 0,
  `MonPayment` decimal(20,2) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  `DueAmountWExtra` decimal(20,2) DEFAULT NULL,
  `RentalDefault` decimal(20,2) DEFAULT NULL,
  `WRentalDefault` decimal(20,2) DEFAULT NULL,
  `TotalDue` decimal(20,2) DEFAULT NULL,
  `RentalBalance` decimal(20,2) DEFAULT NULL,
  `RentalRate` decimal(20,2) DEFAULT NULL,
  `RentalExcuseDays` int(11) DEFAULT NULL,
  `Principal` decimal(20,2) DEFAULT NULL,
  `Interest` decimal(20,2) DEFAULT NULL,
  `ExtraAmount` decimal(20,2) DEFAULT NULL,
  `Balance` decimal(20,2) DEFAULT NULL,
  `IsPaid` tinyint(1) DEFAULT 0,
  `SettleAmount` decimal(20,2) DEFAULT 0.00,
  `IsCancel` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reschedule`
--

CREATE TABLE `reschedule` (
  `id` int(11) NOT NULL,
  `re_date` date NOT NULL,
  `re_cus` int(11) NOT NULL,
  `re_account` varchar(50) NOT NULL,
  `last_account` varchar(50) NOT NULL,
  `re_amount` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returninvoicedtl`
--

CREATE TABLE `returninvoicedtl` (
  `AppNo` int(11) NOT NULL,
  `ReturnNo` varchar(10) NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `ProductCode` varchar(20) NOT NULL,
  `CostPrice` decimal(18,2) NOT NULL,
  `PriceLevel` int(11) NOT NULL,
  `SellingPrice` decimal(18,2) NOT NULL,
  `ReturnQty` decimal(18,2) NOT NULL,
  `ReturnAmount` decimal(18,2) NOT NULL,
  `SalesPersonID` smallint(6) NOT NULL,
  `SerialNo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returninvoicehed`
--

CREATE TABLE `returninvoicehed` (
  `AppNo` int(11) NOT NULL,
  `ReturnNo` varchar(10) NOT NULL,
  `ReturnLocation` smallint(6) NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `InvoiceType` tinyint(4) DEFAULT NULL,
  `RootNo` int(11) NOT NULL,
  `CustomerNo` varchar(10) NOT NULL,
  `ReturnAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `ReturnUser` varchar(20) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsComplete` tinyint(4) DEFAULT NULL,
  `SalesPerson` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `returninvoicehed`
--

INSERT INTO `returninvoicehed` (`AppNo`, `ReturnNo`, `ReturnLocation`, `ReturnDate`, `InvoiceNo`, `InvoiceType`, `RootNo`, `CustomerNo`, `ReturnAmount`, `Remark`, `ReturnUser`, `IsCancel`, `IsComplete`, `SalesPerson`) VALUES
(1, 'RTN0001', 1, '2025-08-12 11:56:56', '0', 1, 1, '10063', 130.00, '', '1', 0, 0, 'EMP0006'),
(1, 'RTN0002', 1, '2025-08-12 12:09:49', '0', 1, 1, '10063', 130.00, '', '1', 0, 0, 'EMP0006'),
(1, 'RTN0010', 1, '2025-07-31 11:39:54', '0', 1, 1, '10062', 130.00, '', '1', 0, 0, 'EMP0010'),
(1, 'RTN0011', 1, '2025-07-31 11:42:22', '0', 1, 1, '10062', 130.00, '', '1', 0, 0, 'EMP0010');

-- --------------------------------------------------------

--
-- Table structure for table `returnnoninvoicessettle`
--

CREATE TABLE `returnnoninvoicessettle` (
  `AppNo` int(11) NOT NULL,
  `ReturnNo` varchar(10) NOT NULL,
  `ReturnLocation` smallint(6) NOT NULL,
  `InvCount` int(11) NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `RootNo` int(11) NOT NULL,
  `CustomerNo` varchar(10) NOT NULL,
  `ReturnAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `ReturnUser` varchar(20) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `IsComplete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_payment`
--

CREATE TABLE `return_payment` (
  `AppNo` int(11) NOT NULL,
  `ReturnNo` varchar(10) NOT NULL,
  `ReturnLocation` smallint(6) NOT NULL,
  `ReturnDate` datetime NOT NULL,
  `InvoiceNo` varchar(10) NOT NULL,
  `InvoiceType` tinyint(4) NOT NULL,
  `RootNo` int(11) NOT NULL,
  `CustomerNo` varchar(10) NOT NULL,
  `ReturnAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(50) NOT NULL,
  `ReturnUser` varchar(20) NOT NULL,
  `IsComplete` tinyint(4) NOT NULL DEFAULT 0,
  `Compete_date` datetime NOT NULL,
  `PaymentType` tinyint(4) NOT NULL,
  `IsOverReturn` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_types`
--

CREATE TABLE `return_types` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `return_types`
--

INSERT INTO `return_types` (`id`, `type`) VALUES
(1, 'Normal'),
(2, 'Damage'),
(3, 'Expired');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` tinyint(4) NOT NULL,
  `role` char(20) DEFAULT NULL,
  `role_description` varchar(100) DEFAULT NULL,
  `role_bgcolor` char(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role`, `role_description`, `role_bgcolor`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Account', NULL, NULL),
(3, 'Manager', NULL, NULL),
(4, 'Cashier', NULL, '#000'),
(5, 'Service Advisor', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoicedtl`
--

CREATE TABLE `salesinvoicedtl` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `SalesInvLocation` smallint(6) NOT NULL,
  `SalesInvDate` datetime NOT NULL,
  `SalesInvLineNo` smallint(6) NOT NULL,
  `SalesProductName` varchar(100) DEFAULT NULL,
  `SalesProductCode` varchar(18) NOT NULL,
  `SalesSerialNo` varchar(50) NOT NULL,
  `SalesCaseOrUnit` varchar(6) NOT NULL,
  `SalesUnitPerCase` decimal(18,2) NOT NULL,
  `SalesQty` decimal(18,2) NOT NULL,
  `SalesFreeQty` decimal(18,2) NOT NULL,
  `SalesReturnQty` decimal(18,2) NOT NULL,
  `SalesPriceLevel` decimal(18,2) NOT NULL,
  `SalesUnitPrice` decimal(18,2) NOT NULL,
  `SalesCostPrice` decimal(18,2) NOT NULL,
  `SalesDisValue` decimal(18,2) NOT NULL,
  `SalesDisPercentage` decimal(18,2) NOT NULL,
  `SalesTotalAmount` decimal(18,2) NOT NULL,
  `SalesInvNetAmount` decimal(18,2) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `SalesPerson` varchar(100) DEFAULT NULL,
  `WarrantyMonth` int(11) DEFAULT NULL,
  `SalesIsVat` tinyint(1) DEFAULT 0,
  `SalesNbtAmount` decimal(18,2) DEFAULT NULL,
  `SalesVatAmount` decimal(18,2) DEFAULT NULL,
  `SalesNbtRatio` decimal(5,2) DEFAULT 1.00,
  `SalesIsNbt` tinyint(1) DEFAULT 0,
  `SellingPriceORG` decimal(18,2) DEFAULT NULL,
  `WarrantyMonthNew` varchar(250) DEFAULT NULL,
  `Is_Return` int(11) NOT NULL DEFAULT 0,
  `ReturnType` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salesinvoicedtl`
--

INSERT INTO `salesinvoicedtl` (`AppNo`, `SalesInvNo`, `SalesInvLocation`, `SalesInvDate`, `SalesInvLineNo`, `SalesProductName`, `SalesProductCode`, `SalesSerialNo`, `SalesCaseOrUnit`, `SalesUnitPerCase`, `SalesQty`, `SalesFreeQty`, `SalesReturnQty`, `SalesPriceLevel`, `SalesUnitPrice`, `SalesCostPrice`, `SalesDisValue`, `SalesDisPercentage`, `SalesTotalAmount`, `SalesInvNetAmount`, `IsReturn`, `SalesPerson`, `WarrantyMonth`, `SalesIsVat`, `SalesNbtAmount`, `SalesVatAmount`, `SalesNbtRatio`, `SalesIsNbt`, `SellingPriceORG`, `WarrantyMonthNew`, `Is_Return`, `ReturnType`) VALUES
(1, 'AEC0039', 1, '2025-09-02 16:15:55', 0, 'BANANA', '100075', '', 'UNIT', 1.00, 10.00, 0.00, 0.00, 1.00, 120.00, 50.00, 0.00, 0.00, 1200.00, 1200.00, 0, '0', NULL, 0, 0.00, 0.00, 1.00, 0, 120.00, 'undefined', 0, 0),
(1, 'AEC0039', 1, '2025-09-02 16:15:55', 1, 'GUAVA', '100077', '', 'UNIT', 1.00, 10.00, 0.00, 0.00, 1.00, 280.00, 180.00, 0.00, 0.00, 2800.00, 2800.00, 0, '0', NULL, 0, 0.00, 0.00, 1.00, 0, 280.00, 'undefined', 0, 0),
(1, 'AEC0040', 1, '2025-09-02 16:16:59', 0, 'GUAVA', '100077', '', '0', 0.00, 10.00, 0.00, 0.00, 1.00, 260.00, 160.00, 0.00, 0.00, 0.00, 2600.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 260.00, '', 0, 0),
(1, 'AEC0040', 1, '2025-09-02 16:16:59', 1, 'GUAVA', '100077', '', '0', 0.00, 0.00, 5.00, 0.00, 1.00, 250.00, 160.00, 0.00, 0.00, 0.00, 0.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 250.00, '', 0, 0),
(1, 'AEC0040', 1, '2025-09-02 16:16:59', 2, 'GRAPES', '100073', '', '0', 0.00, 5.00, 0.00, 0.00, 1.00, 200.00, 100.00, 0.00, 0.00, 0.00, 980.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 200.00, '', 0, 0),
(1, 'AEC0040', 1, '2025-09-02 16:16:59', 3, 'BANANA', '100075', '', '0', 0.00, 5.00, 0.00, 0.00, 1.00, 100.00, 50.00, 0.00, 0.00, 0.00, 500.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 100.00, '', 1, 2),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 0, 'PEPSI - 200ML', '100008', '', '0', 0.00, 120.00, 24.00, 0.00, 1.00, 91.60, 85.00, 0.00, 0.00, 0.00, 10992.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 91.60, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 1, '7UP - 200ML', '100009', '', '0', 0.00, 240.00, 48.00, 0.00, 1.00, 91.60, 85.00, 0.00, 0.00, 0.00, 21984.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 91.60, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 2, 'PEPSI - 400ML', '100005', '', '0', 0.00, 24.00, 0.00, 0.00, 1.00, 187.25, 155.54, 0.00, 0.00, 0.00, 4494.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 187.25, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 3, '7UP - 400ML', '100012', '', '0', 0.00, 24.00, 0.00, 0.00, 1.00, 187.25, 155.54, 0.00, 0.00, 0.00, 4494.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 187.25, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 4, 'MIRINDA - 400ML', '100020', '', '0', 0.00, 48.00, 0.00, 0.00, 1.00, 165.63, 155.54, 0.00, 0.00, 0.00, 7950.24, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 165.63, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 5, 'CREAM SODA - 400ML', '100050', '', '0', 0.00, 24.00, 0.00, 0.00, 1.00, 138.00, 130.00, 0.00, 0.00, 0.00, 3312.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 138.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 6, 'PEPSI - 2000ML', '100004', '', '0', 0.00, 18.00, 0.00, 0.00, 1.00, 448.56, 423.00, 0.00, 0.00, 0.00, 7834.08, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 448.56, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 7, 'SODA (EV) - 400ML', '100061', '', '0', 0.00, 24.00, 2.00, 0.00, 1.00, 92.00, 87.00, 0.00, 0.00, 0.00, 2208.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 92.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 8, 'GINGER BEER - 400ML', '100055', '', '0', 0.00, 24.00, 0.00, 0.00, 1.00, 138.00, 130.00, 0.00, 0.00, 0.00, 3312.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 138.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 9, 'MIRINDA - 2000ML', '100024', '', '0', 0.00, 18.00, 0.00, 0.00, 1.00, 448.56, 422.78, 0.00, 0.00, 0.00, 7834.08, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 448.56, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 10, 'PEPSI - 250ML', '100007', '', '0', 0.00, 150.00, 0.00, 0.00, 1.00, 111.46, 104.29, 0.00, 0.00, 0.00, 15548.67, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 111.46, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 11, 'CREAM SODA - 250ML', '100049', '', '0', 0.00, 60.00, 0.00, 0.00, 1.00, 92.88, 87.00, 0.00, 0.00, 0.00, 5182.70, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 92.88, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 12, '7UP - 2000ML', '100016', '', '0', 0.00, 18.00, 0.00, 0.00, 1.00, 448.56, 422.78, 0.00, 0.00, 0.00, 7834.08, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 448.56, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 13, 'GINGER BEER - 250ML', '100054', '', '0', 0.00, 30.00, 0.00, 0.00, 1.00, 92.88, 87.00, 0.00, 0.00, 0.00, 2591.35, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 92.88, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 14, 'PEPSI - 1000ML', '100002', '', '0', 0.00, 24.00, 2.00, 0.00, 1.00, 282.00, 250.00, 0.00, 0.00, 0.00, 6768.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 282.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 15, '7UP - 1000ML', '100014', '', '0', 0.00, 60.00, 5.00, 0.00, 1.00, 282.00, 263.50, 0.00, 0.00, 0.00, 16920.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 282.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 16, '7UP - 250ML', '100010', '', '0', 0.00, 60.00, 0.00, 0.00, 1.00, 111.46, 104.29, 0.00, 0.00, 0.00, 6219.47, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 111.46, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 17, 'PEPSI - 1500ML', '100001', '', '0', 0.00, 48.00, 0.00, 0.00, 1.00, 372.00, 350.50, 0.00, 0.00, 0.00, 16427.52, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 372.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 18, 'WATER - 1000ML', '100064', '', '0', 0.00, 75.00, 15.00, 0.00, 1.00, 86.67, 80.00, 0.00, 0.00, 0.00, 6500.25, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 86.67, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 19, '7UP - 1500ML', '100015', '', '0', 0.00, 60.00, 0.00, 0.00, 1.00, 372.00, 350.50, 0.00, 0.00, 0.00, 20534.40, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 372.00, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 20, 'PEPSI - 1500ML', '100001', '', '0', 0.00, 5.00, 0.00, 0.00, 1.00, 372.00, 350.50, 0.00, 0.00, 0.00, 1860.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 372.00, '', 1, 3),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 21, 'CREAM SODA - 1000ML', '100051', '', '0', 0.00, 48.00, 4.00, 0.00, 1.00, 252.50, 236.00, 0.00, 0.00, 0.00, 12120.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 252.50, '', 0, 0),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 22, 'PEPSI - 2000ML', '100004', '', '0', 0.00, 2.00, 0.00, 0.00, 1.00, 448.56, 423.00, 0.00, 0.00, 0.00, 897.12, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 448.56, '', 1, 2),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 23, 'PEPSI - 1000ML', '100002', '', '0', 0.00, 3.00, 0.00, 0.00, 1.00, 282.00, 250.00, 0.00, 0.00, 0.00, 846.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 282.00, '', 1, 2),
(1, 'AEC0041', 1, '2025-09-03 12:19:29', 24, '7UP - 1000ML', '100014', '', '0', 0.00, 2.00, 0.00, 0.00, 1.00, 282.00, 263.50, 0.00, 0.00, 0.00, 564.00, 0, '', NULL, 0, 0.00, 0.00, 0.00, 0, 282.00, '', 1, 3),
(1, 'AEC0042', 1, '2025-09-03 12:59:21', 0, 'MIRINDA - 1000ML', '100022', '', 'UNIT', 12.00, 10.00, 0.00, 0.00, 1.00, 282.00, 263.50, 141.00, 5.00, 2820.00, 2679.00, 0, '0', NULL, 0, 0.00, 0.00, 1.00, 0, 282.00, 'undefined', 0, 0),
(1, 'AEC0042', 1, '2025-09-03 12:59:21', 1, 'PEPSI - 400ML', '100005', '', 'UNIT', 24.00, 10.00, 0.00, 0.00, 1.00, 187.25, 155.54, 500.00, 26.70, 1872.50, 1372.50, 0, '0', NULL, 0, 0.00, 0.00, 1.00, 0, 187.25, 'undefined', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoicedtl_copy`
--

CREATE TABLE `salesinvoicedtl_copy` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `SalesInvLocation` smallint(6) NOT NULL,
  `SalesInvDate` datetime NOT NULL,
  `SalesInvLineNo` smallint(6) NOT NULL,
  `SalesProductName` varchar(100) DEFAULT NULL,
  `SalesProductCode` varchar(18) NOT NULL,
  `SalesSerialNo` varchar(50) NOT NULL,
  `SalesCaseOrUnit` varchar(6) NOT NULL,
  `SalesUnitPerCase` decimal(18,2) NOT NULL,
  `SalesQty` decimal(18,2) NOT NULL,
  `SalesFreeQty` decimal(18,2) NOT NULL,
  `SalesReturnQty` decimal(18,0) NOT NULL,
  `SalesPriceLevel` decimal(18,2) NOT NULL,
  `SalesUnitPrice` decimal(18,2) NOT NULL,
  `SalesCostPrice` decimal(18,2) NOT NULL,
  `SalesDisValue` decimal(18,2) NOT NULL,
  `SalesDisPercentage` decimal(18,2) NOT NULL,
  `SalesTotalAmount` decimal(18,2) NOT NULL,
  `SalesInvNetAmount` decimal(18,2) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `SalesPerson` int(11) DEFAULT NULL,
  `WarrantyMonth` int(11) DEFAULT NULL,
  `SalesIsVat` tinyint(1) DEFAULT 0,
  `SalesNbtAmount` decimal(18,2) DEFAULT NULL,
  `SalesVatAmount` decimal(18,2) DEFAULT NULL,
  `SalesNbtRatio` decimal(5,2) DEFAULT 1.00,
  `SalesIsNbt` tinyint(1) DEFAULT 0,
  `SellingPriceORG` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoicehed`
--

CREATE TABLE `salesinvoicehed` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `SalesInvType` tinyint(1) DEFAULT NULL,
  `SalesLocation` smallint(6) NOT NULL,
  `SalesOrderNo` varchar(150) NOT NULL,
  `SalesOrgDate` datetime DEFAULT NULL,
  `SalesDate` datetime NOT NULL,
  `SalesInsCompany` tinyint(4) DEFAULT NULL,
  `SalesCounterNo` varchar(130) NOT NULL,
  `SalesVehicle` varchar(20) DEFAULT NULL,
  `SalesRootNo` smallint(6) NOT NULL,
  `SalesCustomer` varchar(8) NOT NULL,
  `SalesDisAmount` decimal(18,2) NOT NULL,
  `SalesDisPercentage` decimal(18,2) NOT NULL,
  `SalesCashAmount` decimal(18,2) NOT NULL,
  `SalesCCardAmount` decimal(18,2) NOT NULL,
  `SalesCreditAmount` decimal(18,2) NOT NULL,
  `SalesAdvancePayment` decimal(18,2) DEFAULT 0.00,
  `AdvancePayNo` varchar(10) DEFAULT NULL,
  `SalesReturnAmount` decimal(18,2) DEFAULT 0.00,
  `SalesReturnPayment` decimal(18,2) DEFAULT NULL,
  `SalesGiftVAmount` decimal(18,2) NOT NULL,
  `SalesLoyaltyAmount` decimal(18,2) NOT NULL,
  `SalesStarPoints` decimal(18,2) NOT NULL,
  `SalesChequeAmount` decimal(18,2) DEFAULT NULL,
  `SalesInvAmount` decimal(18,2) NOT NULL,
  `SalesIsVat` tinyint(4) NOT NULL,
  `SalesVatAmount` decimal(18,2) NOT NULL,
  `SalesNbtRatio` decimal(5,2) DEFAULT NULL,
  `SalesIsNbt` tinyint(4) NOT NULL,
  `SalesNbtAmount` decimal(18,2) NOT NULL,
  `SalesShipping` decimal(8,2) DEFAULT 0.00,
  `SalesShippingLabel` varchar(30) DEFAULT NULL,
  `SalesBankAmount` decimal(18,2) DEFAULT 0.00,
  `SalesBankAcc` varchar(10) DEFAULT NULL,
  `SalesNetAmount` decimal(18,2) NOT NULL,
  `SalesCustomerPayment` decimal(18,2) NOT NULL,
  `SalesCostAmount` decimal(18,2) NOT NULL,
  `SalesPONumber` varchar(50) DEFAULT NULL,
  `SalesRefundAmount` decimal(18,2) NOT NULL,
  `SalesReceiver` varchar(100) DEFAULT NULL,
  `SalesRecNic` varchar(12) DEFAULT NULL,
  `SalesCommsion` decimal(10,2) DEFAULT NULL,
  `SalesComCus` varchar(10) DEFAULT NULL,
  `SalesInvUser` varchar(20) NOT NULL,
  `SalesPerson` varchar(250) DEFAULT NULL,
  `SalesInvHold` tinyint(4) NOT NULL,
  `InvIsCancel` tinyint(4) NOT NULL,
  `IsComplete` tinyint(4) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL,
  `salesInvRemark` longtext DEFAULT NULL,
  `refferNo` varchar(100) NOT NULL,
  `RouteId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salesinvoicehed`
--

INSERT INTO `salesinvoicehed` (`AppNo`, `SalesInvNo`, `SalesInvType`, `SalesLocation`, `SalesOrderNo`, `SalesOrgDate`, `SalesDate`, `SalesInsCompany`, `SalesCounterNo`, `SalesVehicle`, `SalesRootNo`, `SalesCustomer`, `SalesDisAmount`, `SalesDisPercentage`, `SalesCashAmount`, `SalesCCardAmount`, `SalesCreditAmount`, `SalesAdvancePayment`, `AdvancePayNo`, `SalesReturnAmount`, `SalesReturnPayment`, `SalesGiftVAmount`, `SalesLoyaltyAmount`, `SalesStarPoints`, `SalesChequeAmount`, `SalesInvAmount`, `SalesIsVat`, `SalesVatAmount`, `SalesNbtRatio`, `SalesIsNbt`, `SalesNbtAmount`, `SalesShipping`, `SalesShippingLabel`, `SalesBankAmount`, `SalesBankAcc`, `SalesNetAmount`, `SalesCustomerPayment`, `SalesCostAmount`, `SalesPONumber`, `SalesRefundAmount`, `SalesReceiver`, `SalesRecNic`, `SalesCommsion`, `SalesComCus`, `SalesInvUser`, `SalesPerson`, `SalesInvHold`, `InvIsCancel`, `IsComplete`, `Flag`, `salesInvRemark`, `refferNo`, `RouteId`) VALUES
(1, 'AEC0039', 3, 0, '', '2025-09-02 16:15:55', '2025-09-02 16:15:55', 0, '', '', 0, '10071', 0.00, 0.00, 1000.00, 0.00, 3000.00, 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4000.00, 0, 0.00, 0.50, 0, 0.00, 0.00, '', 0.00, '', 4000.00, 1000.00, 2300.00, '', 0.00, '', '', 0.00, '', '1', '', 0, 0, 0, NULL, '', '', 0),
(1, 'AEC0040', 3, 0, '', '2025-09-02 16:16:59', '2025-09-02 16:16:59', 0, '', '', 0, '10071', 0.00, 0.00, 1000.00, 0.00, 2580.00, 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 3580.00, 0, 0.00, 0.50, 0, 0.00, 0.00, '', 0.00, '', 3580.00, 1000.00, 2350.00, 'TSE0067', 0.00, '', '', 0.00, '', '1', '', 0, 0, 0, NULL, '', '', 0),
(1, 'AEC0041', 3, 0, '', '2025-09-03 12:19:29', '2025-09-03 12:19:29', 0, '', '', 0, '10018', 0.00, 0.00, 0.00, 0.00, 191060.84, 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 191060.84, 0, 0.00, 0.50, 0, 0.00, 0.00, '', 0.00, '', 191060.84, 0.00, 187292.32, 'TSE0074', 0.00, '', '', 0.00, '', '1', 'EMP0001', 0, 0, 0, NULL, '', '', 1),
(1, 'AEC0042', 3, 0, '', '2025-09-03 12:59:21', '2025-09-03 12:59:21', 0, '', '', 0, '10062', 641.00, 0.00, 400.00, 0.00, 3651.50, 0.00, '0', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4692.50, 0, 0.00, 0.50, 0, 0.00, 0.00, '', 0.00, '', 4051.50, 400.00, 4190.40, '', 0.00, '', '', 0.00, '', '1', 'EMP0010', 0, 0, 0, NULL, '', '', 13);

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoicepaydtl`
--

CREATE TABLE `salesinvoicepaydtl` (
  `AppNo` int(11) NOT NULL,
  `SalesInvNo` varchar(10) NOT NULL,
  `SalesInvDate` datetime NOT NULL,
  `SalesInvPayType` varchar(10) NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `Reference` varchar(20) NOT NULL,
  `SalesInvPayAmount` decimal(18,2) NOT NULL,
  `PayRemark` varchar(100) DEFAULT NULL,
  `ReceiptNo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salesinvoicepaydtl`
--

INSERT INTO `salesinvoicepaydtl` (`AppNo`, `SalesInvNo`, `SalesInvDate`, `SalesInvPayType`, `Mode`, `Reference`, `SalesInvPayAmount`, `PayRemark`, `ReceiptNo`) VALUES
(1, 'AEC0001', '2025-08-12 13:16:28', 'Credit', '', '', 111.46, NULL, NULL),
(1, 'AEC0002', '2025-08-12 13:23:25', 'Cash', 'AEC0002', 'AEC0002', 11.00, NULL, NULL),
(1, 'AEC0002', '2025-08-12 13:23:25', 'Credit', '', '', 100.00, NULL, NULL),
(1, 'AEC0003', '2025-08-12 13:36:19', 'Credit', '', '', 111.00, NULL, NULL),
(1, 'AEC0004', '2025-08-12 14:23:30', 'Cash', 'AEC0004', 'AEC0004', 11.00, NULL, NULL),
(1, 'AEC0004', '2025-08-12 14:23:30', 'Credit', '', '', 100.00, NULL, NULL),
(1, 'AEC0005', '2025-08-12 15:04:28', 'Cash', 'AEC0005', 'AEC0005', 11.00, NULL, NULL),
(1, 'AEC0005', '2025-08-12 15:04:28', 'Credit', '', '', 100.00, NULL, NULL),
(1, 'AEC0006', '2025-08-13 12:28:15', 'Credit', '', '', 1300.00, NULL, NULL),
(1, 'AEC0007', '2025-08-13 12:29:23', 'Credit', '', '', 111.00, NULL, NULL),
(1, 'AEC0008', '2025-08-13 12:32:22', 'Cash', 'AEC0008', 'AEC0008', 80.00, NULL, NULL),
(1, 'AEC0008', '2025-08-13 12:32:22', 'Credit', '', '', 85.00, NULL, NULL),
(1, 'AEC0009', '2025-08-13 13:43:35', 'Credit', '', '', 91.00, NULL, NULL),
(1, 'AEC0010', '2025-08-21 14:05:59', 'Credit', '', '', 3126.93, NULL, NULL),
(1, 'AEC0011', '2025-08-21 14:57:33', 'Credit', '', '', 80.00, NULL, NULL),
(1, 'AEC0012', '2025-08-21 15:02:55', 'Credit', '', '', 1350.00, NULL, NULL),
(1, 'AEC0013', '2025-08-26 14:03:01', 'Credit', '', '', 18320.00, NULL, NULL),
(1, 'AEC0014', '2025-08-26 14:19:51', 'Credit', '', '', 1099.20, NULL, NULL),
(1, 'AEC0015', '2025-08-27 14:00:34', 'Credit', '', '', 183.20, NULL, NULL),
(1, 'AEC0016', '2025-08-27 15:49:57', 'Credit', '', '', 549.60, NULL, NULL),
(1, 'AEC0017', '2025-08-28 12:51:03', 'Credit', '', '', 900.00, NULL, NULL),
(1, 'AEC0018', '2025-08-28 13:02:25', 'Credit', '', '', 432.00, NULL, NULL),
(1, 'AEC0019', '2025-08-28 17:05:22', 'Credit', '', '', 641.20, NULL, NULL),
(1, 'AEC0020', '2025-08-29 15:23:24', 'Credit', '', '', 1180.80, NULL, NULL),
(1, 'AEC0021', '2025-08-30 09:22:06', 'Credit', '', '', 2380.05, NULL, NULL),
(1, 'AEC0022', '2025-08-30 09:38:36', 'Credit', '', '', 3720.00, NULL, NULL),
(1, 'AEC0023', '2025-08-30 09:50:02', 'Credit', '', '', 253.75, NULL, NULL),
(1, 'AEC0024', '2025-08-30 12:43:01', 'Credit', '', '', 372.00, NULL, NULL),
(1, 'AEC0025', '2025-08-30 14:19:50', 'Credit', '', '', 2750.00, NULL, NULL),
(1, 'AEC0026', '2025-08-30 14:35:48', 'Credit', '', '', 2750.00, NULL, NULL),
(1, 'AEC0027', '2025-09-01 09:54:16', 'Credit', '', '', 450.00, NULL, NULL),
(1, 'AEC0030', '2025-09-02 09:53:01', 'Credit', '', '', 1625.00, NULL, NULL),
(1, 'AEC0031', '2025-09-02 10:39:35', 'Credit', '', '', 600.00, NULL, NULL),
(1, 'AEC0032', '2025-09-02 15:14:34', 'Credit', '', '', 1100.00, NULL, NULL),
(1, 'AEC0033', '2025-09-02 15:19:53', 'Credit', '', '', 2600.00, NULL, NULL),
(1, 'AEC0034', '2025-09-02 15:43:44', 'Credit', '', '', 1000.00, NULL, NULL),
(1, 'AEC0035', '2025-09-02 15:58:10', 'Credit', '', '', 2340.00, NULL, NULL),
(1, 'AEC0036', '2025-09-02 15:58:24', 'Credit', '', '', 2340.00, NULL, NULL),
(1, 'AEC0037', '2025-09-02 16:00:16', 'Credit', '', '', 2340.00, NULL, NULL),
(1, 'AEC0038', '2025-09-02 16:02:11', 'Credit', '', '', 110.00, NULL, NULL),
(1, 'AEC0039', '2025-09-02 16:15:55', 'Cash', 'AEC0039', 'AEC0039', 1000.00, NULL, NULL),
(1, 'AEC0039', '2025-09-02 16:15:55', 'Credit', '', '', 3000.00, NULL, NULL),
(1, 'AEC0040', '2025-09-02 16:16:59', 'Cash', 'AEC0040', 'AEC0040', 1000.00, NULL, NULL),
(1, 'AEC0040', '2025-09-02 16:16:59', 'Credit', '', '', 2580.00, NULL, NULL),
(1, 'AEC0041', '2025-09-03 12:19:29', 'Credit', '', '', 191060.84, NULL, NULL),
(1, 'AEC0042', '2025-09-03 12:59:21', 'Cash', 'AEC0042', 'AEC0042', 400.00, NULL, NULL),
(1, 'AEC0042', '2025-09-03 12:59:21', 'Credit', '', '', 3651.50, NULL, NULL),
(1, 'WI0001', '2025-08-12 13:12:27', 'Cash', 'WI0001', 'WI0001', 130.00, NULL, NULL),
(1, 'WI0002', '2025-08-12 13:37:41', 'Cash', 'WI0002', 'WI0002', 111.00, NULL, NULL),
(1, 'WI0004', '2025-08-13 11:42:03', 'Cash', 'WI0004', 'WI0004', 222.00, NULL, NULL),
(1, 'WI0005', '2025-08-13 11:42:41', 'Cash', 'WI0005', 'WI0005', 222.00, NULL, NULL),
(1, 'WI0006', '2025-08-13 11:46:09', 'Cash', 'WI0006', 'WI0006', 222.00, NULL, NULL),
(1, 'WI0007', '2025-08-13 12:26:02', 'Cash', 'WI0007', 'WI0007', 60.00, NULL, NULL),
(1, 'WI0008', '2025-08-13 12:41:56', 'Cash', 'WI0008', 'WI0008', 33567.00, NULL, NULL),
(1, 'WI0009', '2025-08-13 12:43:21', 'Cash', 'WI0009', 'WI0009', 17478.00, NULL, NULL),
(1, 'WI0010', '2025-08-13 13:07:53', 'Cash', 'WI0010', 'WI0010', 1872.00, NULL, NULL),
(1, 'WI0011', '2025-08-13 13:12:11', 'Cash', 'WI0011', 'WI0011', 1114.00, NULL, NULL),
(1, 'WI0012', '2025-08-13 13:15:08', 'Cash', 'WI0012', 'WI0012', 92.00, NULL, NULL),
(1, 'WI0013', '2025-08-13 13:16:57', 'Cash', 'WI0013', 'WI0013', 29461.00, NULL, NULL),
(1, 'WI0014', '2025-08-13 13:21:35', 'Cash', 'WI0014', 'WI0014', 40323.00, NULL, NULL),
(1, 'WI0015', '2025-08-13 13:30:35', 'Cash', 'WI0015', 'WI0015', 140455.00, NULL, NULL),
(1, 'WI0016', '2025-08-21 10:16:18', 'Cash', 'WI0016', 'WI0016', 1116.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salespersons`
--

CREATE TABLE `salespersons` (
  `RepID` varchar(10) NOT NULL,
  `LocationCode` smallint(6) NOT NULL,
  `EmpNo` varchar(10) NOT NULL,
  `RepType` tinyint(4) DEFAULT NULL,
  `RepName` varchar(60) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `RepImage` longblob DEFAULT NULL,
  `IsSalesPerson` tinyint(1) NOT NULL,
  `IsTec` tinyint(1) DEFAULT 0,
  `Skill` tinyint(4) DEFAULT NULL,
  `IsAccount` tinyint(1) DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salespersons`
--

INSERT INTO `salespersons` (`RepID`, `LocationCode`, `EmpNo`, `RepType`, `RepName`, `ContactNo`, `Email`, `Remark`, `RepImage`, `IsSalesPerson`, `IsTec`, `Skill`, `IsAccount`, `IsActive`) VALUES
('EMP0001', 1, '09', 6, 'Mr.Duvindu Sandaruwan', '+94753630260', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0002', 1, '04', 6, 'Mr.Sanjula Madushan', '+94774312940', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0003', 1, '11', 6, 'Mr.Hansaka Dilan', '+94755422023', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0004', 1, '', 6, 'Test Employee', '+94458796321', 'sathutu12@gmail.com', '', NULL, 0, 0, 1, 0, 1),
('EMP0005', 1, '123', 6, 'TEST ', '+94111111111', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0006', 0, '', 6, 'Priyani', '+94546464654', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0007', 0, '001', 6, 'Test_Emp', '+94544646464', 'testemp@gmail.com', 'Test Employee', NULL, 0, 0, 1, 0, 1),
('EMP0008', 1, 'EMP0008', 6, 'test 123', '+94543564678', 'sdfgfdsa@gmail.com', 'sdfds', NULL, 1, 0, 1, 0, 1),
('EMP0009', 1, '1', 6, 'TESTING NN', '+94111111111', '', '', NULL, 0, 0, 1, 0, 1),
('EMP0010', 1, '', 6, 'EMP_New', '+94544646545', 'empnew@gmail.com', '', NULL, 0, 0, 1, 0, 1),
('EMP0011', 1, '0001', 6, 'TEST NNN', '+94777777777', '', '', NULL, 1, 0, 1, 0, 1),
('EMP0012', 1, '', 6, 'TEST RRR', '+94111111111', '', '', NULL, 1, 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salespersonsaccount`
--

CREATE TABLE `salespersonsaccount` (
  `spId` text NOT NULL,
  `username` text NOT NULL,
  `password` text DEFAULT NULL,
  `IsActive` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `salespersonsaccount`
--

INSERT INTO `salespersonsaccount` (`spId`, `username`, `password`, `IsActive`) VALUES
('EMP0008', 'test', '345', 1);

-- --------------------------------------------------------

--
-- Table structure for table `salespersons_copy`
--

CREATE TABLE `salespersons_copy` (
  `RepID` varchar(10) NOT NULL,
  `LocationCode` smallint(6) NOT NULL,
  `EmpNo` varchar(10) NOT NULL,
  `RepType` tinyint(4) DEFAULT NULL,
  `RepName` varchar(60) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `RepImage` longblob DEFAULT NULL,
  `IsSalesPerson` tinyint(1) NOT NULL,
  `IsTec` tinyint(1) DEFAULT 0,
  `Skill` tinyint(4) DEFAULT NULL,
  `IsAccount` tinyint(1) DEFAULT 0,
  `IsActive` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skill_level`
--

CREATE TABLE `skill_level` (
  `skill_id` tinyint(4) NOT NULL,
  `skill_level` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `skill_level`
--

INSERT INTO `skill_level` (`skill_id`, `skill_level`) VALUES
(1, 'Skilled'),
(2, 'No-Skill');

-- --------------------------------------------------------

--
-- Table structure for table `sms_config`
--

CREATE TABLE `sms_config` (
  `sms_id` tinyint(4) NOT NULL,
  `account_id` varchar(15) DEFAULT NULL,
  `acc_password` varchar(5) DEFAULT NULL,
  `credit_rate` varchar(10) DEFAULT NULL,
  `credit` decimal(5,2) DEFAULT 0.50,
  `location` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `sms_config`
--

INSERT INTO `sms_config` (`sms_id`, `account_id`, `acc_password`, `credit_rate`, `credit`, `location`) VALUES
(1, '94753778021', '9267', 'Y', 0.50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ProductCode` varchar(20) NOT NULL,
  `ProductName` varchar(160) NOT NULL,
  `Location` tinyint(1) NOT NULL,
  `Stock` int(11) NOT NULL,
  `CostPrice` decimal(10,2) NOT NULL,
  `SellingPrice` decimal(10,2) NOT NULL,
  `Category` varchar(20) NOT NULL,
  `LastUpdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockdate`
--

CREATE TABLE `stockdate` (
  `ProductCode` varchar(20) NOT NULL,
  `StockDate` date NOT NULL,
  `Stock` decimal(18,2) NOT NULL,
  `Location` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockdateuser`
--

CREATE TABLE `stockdateuser` (
  `id` int(11) NOT NULL,
  `lastupdate` datetime DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocktransferdtl`
--

CREATE TABLE `stocktransferdtl` (
  `TrnsNo` varchar(10) NOT NULL,
  `Location` int(11) NOT NULL,
  `TrnsDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `ProductCode` varchar(18) NOT NULL,
  `CaseOrUnit` varchar(6) NOT NULL,
  `UnitPerCase` decimal(18,2) NOT NULL,
  `TransQty` decimal(18,2) NOT NULL,
  `CostPrice` decimal(18,2) NOT NULL,
  `TransAmount` decimal(18,2) NOT NULL,
  `PriceLevel` int(11) NOT NULL,
  `SellingPrice` decimal(18,2) NOT NULL,
  `DismissQty` decimal(18,2) NOT NULL,
  `IsSerial` tinyint(4) NOT NULL,
  `Serial` varchar(20) NOT NULL,
  `ReturnStatus` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocktransferhed`
--

CREATE TABLE `stocktransferhed` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `TrnsNo` varchar(10) NOT NULL,
  `TransDateORG` datetime NOT NULL,
  `TrnsDate` datetime NOT NULL,
  `FromLocation` int(11) NOT NULL,
  `ToLocation` int(11) NOT NULL,
  `CostAmount` decimal(18,2) NOT NULL,
  `Remark` varchar(100) NOT NULL,
  `TransUser` varchar(15) NOT NULL,
  `TransIsInProcess` tinyint(4) NOT NULL,
  `TransInDate` datetime NOT NULL,
  `TransInUser` varchar(15) NOT NULL,
  `TransInRemark` varchar(100) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_location`
--

CREATE TABLE `store_location` (
  `store_id` smallint(6) NOT NULL,
  `bin_no` varchar(255) DEFAULT NULL,
  `store_rack` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `DepCode` smallint(6) NOT NULL,
  `SubDepCode` smallint(6) NOT NULL,
  `CategoryCode` int(11) NOT NULL,
  `SubCategoryCode` int(11) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`DepCode`, `SubDepCode`, `CategoryCode`, `SubCategoryCode`, `Description`, `Flag`) VALUES
(4, 4, 1, 1, '-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subdepartment`
--

CREATE TABLE `subdepartment` (
  `DepCode` smallint(6) NOT NULL,
  `SubDepCode` smallint(6) NOT NULL,
  `Description` varchar(30) NOT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `subdepartment`
--

INSERT INTO `subdepartment` (`DepCode`, `SubDepCode`, `Description`, `Flag`) VALUES
(1, 1, '200 ML', NULL),
(1, 5, '250ML', NULL),
(1, 6, '300 ML', NULL),
(1, 7, '400 ML', NULL),
(1, 8, '750 ML', NULL),
(1, 9, '1000 ML', NULL),
(1, 10, '1500 ML', NULL),
(1, 11, '2000 ML', NULL),
(1, 55, '-', NULL),
(2, 2, '200 ML', NULL),
(2, 20, '250ML', NULL),
(2, 21, '750 ML', NULL),
(2, 22, '1000 ML', NULL),
(2, 53, '-', NULL),
(2, 64, '400ML', NULL),
(3, 3, '200 ML', NULL),
(3, 12, '250ML', NULL),
(3, 13, '300 ML', NULL),
(3, 14, '400 ML', NULL),
(3, 15, '750 ML', NULL),
(3, 17, '1000 ML', NULL),
(3, 18, '1500 ML', NULL),
(3, 19, '2000 ML', NULL),
(3, 56, '-', NULL),
(4, 4, '200 ML', NULL),
(4, 23, '250ML', NULL),
(4, 24, '400 ML', NULL),
(4, 25, '750 ML', NULL),
(4, 26, '1500 ML', NULL),
(4, 54, '-', NULL),
(4, 59, '-', NULL),
(5, 27, '200 ML', NULL),
(5, 28, '250ML', NULL),
(5, 29, '400 ML', NULL),
(5, 30, '750 ML', NULL),
(5, 31, '1500 ML', NULL),
(5, 58, '-', NULL),
(6, 32, '200 ML', NULL),
(6, 33, '250ML', NULL),
(6, 34, '750 ML', NULL),
(6, 35, '1000 ML', NULL),
(7, 36, '200 ML', NULL),
(7, 37, '250ML', NULL),
(7, 38, '750 ML', NULL),
(7, 51, '-', NULL),
(8, 50, '-', NULL),
(9, 52, '-', NULL),
(9, 57, '-', NULL),
(10, 39, 'sting', NULL),
(10, 40, 'Mirinda', NULL),
(10, 41, 'zingo', NULL),
(10, 42, 'G B', NULL),
(10, 43, 'Water', NULL),
(10, 44, '300 ML', NULL),
(10, 46, 'Mountan Dew', NULL),
(10, 47, '200 ML', NULL),
(11, 45, 'Sub_Dep', NULL),
(12, 48, '-', NULL),
(13, 49, '-', NULL),
(13, 62, '-', NULL),
(15, 60, '-', NULL),
(16, 61, '1000ML', NULL),
(17, 63, '-', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `SupTitle` varchar(10) DEFAULT NULL,
  `SupCode` varchar(10) NOT NULL,
  `SupName` varchar(60) NOT NULL,
  `ContactPerson` varchar(100) NOT NULL,
  `Remark` text NOT NULL,
  `Address01` varchar(150) NOT NULL,
  `Address02` varchar(150) NOT NULL,
  `Address03` text NOT NULL,
  `MobileNo` varchar(25) NOT NULL,
  `LanLineNo` varchar(25) NOT NULL,
  `Fax` varchar(25) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `CreditPeriod` decimal(18,0) NOT NULL,
  `IsActive` tinyint(4) DEFAULT NULL,
  `Flag` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupTitle`, `SupCode`, `SupName`, `ContactPerson`, `Remark`, `Address01`, `Address02`, `Address03`, `MobileNo`, `LanLineNo`, `Fax`, `Email`, `CreditPeriod`, `IsActive`, `Flag`) VALUES
('8', 'SUP0001', 'Varun Beverages Lanka Pvt Ltd', '-', 'Milk Product', 'No 140,', 'Low Level Rd, Embulgama,', 'Ranala.', '+94114409300', '+94', '+94', '', 0, 1, NULL),
('8', 'SUP0002', 'Ole Springs Bottlers Pvt Ltd', '', 'Biscuit Supplier', 'No 140,', 'Low Level Rd, Embulgama,', 'Ranala.', '+94114409300', '+94114409305', '+94', '', 0, 1, NULL),
('1', 'SUP0003', 'Sup 3', 'Amal', '', '137/2 ', 'Main Street ', ' Ratnapura', '+94846884687', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0004', 'Sup 3', 'Amal', '', '137/2 ', 'Main Street ', ' Ratnapura', '+94846884687', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0005', 'Sup 3', 'Amal', '', '137/2 ', 'Main Street ', ' Ratnapura', '+94846884687', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0006', 'Sup 3', 'Amal', '', '137/2 ', 'Main Street ', ' Ratnapura', '+94846884687', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0007', 'Sup 3', 'Amal', '', '137/2 ', 'Main Street ', ' Ratnapura', '+94846884687', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0008', 'Sup 4', 'AMAL', '', '137/2 ', 'Main Street', 'Opanayaka', '+94446465465', '+94', '+94', '', 0, NULL, NULL),
('1', 'SUP0009', 'Pawan', 'AMAL', '', '137/2 ', 'Main Street', 'Ratnapura', '+94895666565', '+94', '+94', 'nuwannsoft@gmail.com', 10, NULL, NULL),
('1', 'SUP0010', 'Kamal', 'abc', '', 'RATNAPURA', 'Ratnapura', 'Opanayaka', '+94465464564', '+94656465465', '+94', 'admin@nsteel.aldtan.net', 0, NULL, NULL),
('1', 'SUP0011', 'TEST_SUPPLIER', 'Test_Contact', 'test supllier', '137/2 ', 'Main Street', 'Ratnapura', '+94655444656', '+94846464546', '+944654644', 'testsupplier@gmail.com', 0, NULL, NULL),
('1', 'SUP0012', 'TEST_SUPPLIER', 'Test_Contact', 'test supllier', '137/2 ', 'Main Street', 'Ratnapura', '+94655444656', '+94846464546', '+9446546444', 'testsupplier@gmail.com', 10, 1, NULL),
('0', 'SUP0013', 'Sathutu Lanka (Pvt) Ltd', '', '', '', '', '', '+94114409300', '+94', '+94', '', 0, 1, NULL),
('1', 'SUP0014', 'Test_Sup_1', '', '', 'a', 'aa', 'aaa', '+94454544654', '+94', '+94', '', 0, 1, NULL),
('0', 'SUP0015', 'test 18', '', '', '', '', '', '+94598556353', '+94656685653', '+94', 'bgfgh@ghfdf', 0, 1, NULL),
('1', 'SUP0016', 'test sup 2', 'abc', '', '123', 'aaaa', 'aaaaaa', '+94846465456', '+94', '+94', '', 0, 1, NULL),
('1', 'SUP0017', 'TSUP', '', '', '', '', '', '+94468546845', '+94', '+94', '', 0, 1, NULL),
('1', 'SUP0018', 'TESTING NN SUP', '', '', 'RATNAPURA', '', '', '+94778123867', '+94', '+94', '', 0, 1, NULL),
('1', 'SUP0019', 'Sup_New', 'Kamal', '', 'Balangoda', '', '', '+94854646467', '+94456464654', '+94231341343', 'supnew@gmail.con', 0, 1, NULL),
('1', 'SUP0020', 'Supplier 1', '', '', '', '', '', '+94758962225', '+94', '+94', '', 0, 1, NULL),
('1', 'SUP0021', 'NNNN', 'nsoft solutions', '', 'Paradise', '', '', '+94777777777', '+94', '+94', '', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplieroustanding`
--

CREATE TABLE `supplieroustanding` (
  `SupCode` varchar(8) NOT NULL,
  `SupTotalInvAmount` decimal(18,2) NOT NULL,
  `SupOustandingAmount` decimal(18,2) NOT NULL,
  `SupSettlementAmount` decimal(18,2) NOT NULL,
  `OpenOustanding` decimal(18,2) NOT NULL,
  `OustandingDueAmount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplieroustanding`
--

INSERT INTO `supplieroustanding` (`SupCode`, `SupTotalInvAmount`, `SupOustandingAmount`, `SupSettlementAmount`, `OpenOustanding`, `OustandingDueAmount`) VALUES
('SUP0001', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0002', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0003', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0004', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0005', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0006', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0007', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0008', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0009', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0010', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0011', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0012', 4850.00, 4850.00, 0.00, 0.00, 0.00),
('SUP0013', 8029215.80, 8029215.80, 0.00, 0.00, 0.00),
('SUP0014', 1700.00, 1700.00, 0.00, 0.00, 0.00),
('SUP0015', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0016', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0017', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0018', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0019', 0.00, 0.00, 0.00, 0.00, 0.00),
('SUP0020', 10155.54, 10155.54, 0.00, 0.00, 0.00),
('SUP0021', 15800.00, 3900.00, 11400.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplierpaymentdtl`
--

CREATE TABLE `supplierpaymentdtl` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `SupPayNo` varchar(10) NOT NULL,
  `InvoiceNo` varchar(10) DEFAULT NULL,
  `PayDate` datetime NOT NULL,
  `Mode` varchar(10) NOT NULL,
  `PayAmount` decimal(18,2) NOT NULL,
  `BankNo` smallint(6) NOT NULL,
  `ChequeNo` varchar(15) NOT NULL,
  `ChequeDate` datetime NOT NULL,
  `RecievedDate` datetime NOT NULL,
  `Reference` varchar(150) NOT NULL,
  `IsReturn` tinyint(4) NOT NULL,
  `IsRelease` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplierpaymentdtl`
--

INSERT INTO `supplierpaymentdtl` (`AppNo`, `Location`, `SupPayNo`, `InvoiceNo`, `PayDate`, `Mode`, `PayAmount`, `BankNo`, `ChequeNo`, `ChequeDate`, `RecievedDate`, `Reference`, `IsReturn`, `IsRelease`) VALUES
(1, 1, 'SPM0001', NULL, '2025-09-02 15:01:17', 'Cash', 6200.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 'SPM0002', NULL, '2025-09-02 15:01:43', 'Cash', 5200.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0),
(1, 1, 'SPM0003', NULL, '2025-09-02 16:11:27', 'Cash', 500.00, 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplierpaymenthed`
--

CREATE TABLE `supplierpaymenthed` (
  `AppNo` int(11) NOT NULL,
  `Location` int(11) NOT NULL,
  `SupPayNo` varchar(8) NOT NULL,
  `PayDate` datetime NOT NULL,
  `RootNo` int(11) NOT NULL,
  `SupCode` varchar(10) NOT NULL,
  `Remark` varchar(150) NOT NULL,
  `CashPay` decimal(18,2) NOT NULL,
  `ChequePay` decimal(18,2) NOT NULL,
  `CardPay` decimal(18,2) NOT NULL,
  `TotalPayment` decimal(18,2) NOT NULL,
  `AvailableOustanding` decimal(18,2) NOT NULL,
  `IsCancel` tinyint(4) NOT NULL,
  `CancelUser` varchar(15) NOT NULL,
  `SystemUser` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `supplierpaymenthed`
--

INSERT INTO `supplierpaymenthed` (`AppNo`, `Location`, `SupPayNo`, `PayDate`, `RootNo`, `SupCode`, `Remark`, `CashPay`, `ChequePay`, `CardPay`, `TotalPayment`, `AvailableOustanding`, `IsCancel`, `CancelUser`, `SystemUser`) VALUES
(1, 1, 'SPM0001', '2025-09-02 15:01:17', 0, 'SUP0021', '', 6200.00, 0.00, 0.00, 6200.00, 8300.00, 0, '0', '1'),
(1, 1, 'SPM0002', '2025-09-02 15:01:43', 0, 'SUP0021', '', 5200.00, 0.00, 0.00, 5200.00, 3100.00, 0, '0', '1'),
(1, 1, 'SPM0003', '2025-09-02 16:11:27', 0, 'SUP0021', '', 500.00, 0.00, 0.00, 500.00, 4400.00, 0, '0', '1');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_routes`
--

CREATE TABLE `supplier_routes` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemoptions`
--

CREATE TABLE `systemoptions` (
  `ID` varchar(4) NOT NULL,
  `Description` varchar(50) NOT NULL,
  `Value` varchar(200) NOT NULL,
  `Remark` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `systemoptions`
--

INSERT INTO `systemoptions` (`ID`, `Description`, `Value`, `Remark`) VALUES
('A001', 'Active POS', 'True', ''),
('A002', 'Active Distribution ', 'True', ''),
('A003', 'Active Barcode', 'True', ''),
('B001', 'Is Multi Price Enable', 'True', ' '),
('B002', 'Allow Minus Stock', 'False', ' '),
('B003', 'Allow Credit Payments', 'True', ' '),
('B004', 'Show Product Image', 'True', ' '),
('B005', 'Select Print Invoice', '2', ' '),
('B006', 'PO Code Is Enable', 'True', ' '),
('B007', 'Is Sales Persons [POS]', 'True', ' '),
('B008', 'Is Sales Persons [Distribution]', 'True', ' '),
('B009', 'Focus Cash Sales [POS]', 'True', ' '),
('B010', 'Print Invoice Copies', '1', ' '),
('B011', 'Focus Credit Sales [DISTRIBUTION]', 'True', 'T'),
('B012', 'Com Port Display', '2', ''),
('B013', 'Under Cost', 'False', 'T'),
('B014', 'Auto Discount', '2', '1 = Auto discount , 2 = Limit Discount'),
('B015', 'Total Discount Limit', '16', '0-99'),
('B016', 'Enable Adjust Net Amount', 'False', '0-99'),
('B017', 'Total Dis Amount Limit', '100', ''),
('G001', 'Sinhala Description', 'False', ' '),
('M001', 'Update Cost Price', '1', ''),
('M002', 'Auto Product Code', '1', ' '),
('M003', 'Update Selling Price in Transfer', '1', ' Selling price update location to another location'),
('S001', 'Backup Path', 'I:\\Auto Backup', 'T'),
('S002', 'Scale Item txt path', 'E:\\Scale\\temp.txt', 'T'),
('W001', 'Server Name', '50.62.209.43', '50.62.209.43'),
('W002', 'User', 'nsoft_ramith', 'nsoft_ramith'),
('W003', 'PW', 'Nuwan1981@', 'Nuwan1981@'),
('W004', 'DB Name', 'pos', 'pos');

-- --------------------------------------------------------

--
-- Table structure for table `system_module`
--

CREATE TABLE `system_module` (
  `id` int(11) NOT NULL,
  `moduleName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_module`
--

INSERT INTO `system_module` (`id`, `moduleName`) VALUES
(1, 'Dashboard'),
(2, 'Customer'),
(3, 'All Job Cards'),
(4, 'Invoice'),
(5, 'All Estimate'),
(6, 'Products'),
(7, 'Master Forms'),
(8, 'Reporting'),
(9, 'Good Received Note'),
(10, 'Payment'),
(11, 'Purchase'),
(12, 'Parts Request'),
(13, 'Invoice - Return/ Cancel'),
(14, 'Admin Privileges'),
(15, 'Cash Float'),
(16, 'Print'),
(17, 'Cost Price');

-- --------------------------------------------------------

--
-- Table structure for table `system_permission_define`
--

CREATE TABLE `system_permission_define` (
  `id` int(11) NOT NULL,
  `per_code` varchar(50) NOT NULL,
  `per_class` varchar(250) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_view` int(11) NOT NULL DEFAULT 0,
  `is_add` int(11) NOT NULL DEFAULT 0,
  `is_edit` int(11) NOT NULL DEFAULT 0,
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_permission_define`
--

INSERT INTO `system_permission_define` (`id`, `per_code`, `per_class`, `module_id`, `is_view`, `is_add`, `is_edit`, `is_delete`) VALUES
(1, 'M1', 'Dashboard', 1, 0, 0, 0, 0),
(2, 'M2', 'Customer', 2, 0, 0, 0, 0),
(3, 'M3', 'All Job Cards', 3, 0, 0, 0, 0),
(4, 'M4', 'Invoice', 4, 0, 0, 0, 0),
(5, 'M5', 'All Estimate', 5, 0, 0, 0, 0),
(6, 'M6', 'Products', 6, 0, 0, 0, 0),
(7, 'M7', 'Master Forms', 7, 0, 0, 0, 0),
(8, 'M8', 'Reporting', 8, 0, 0, 0, 0),
(9, 'M9', 'Good Received Note', 9, 0, 0, 0, 0),
(10, 'M10', 'Payment', 10, 0, 0, 0, 0),
(11, 'M11', 'Purchase', 11, 0, 0, 0, 0),
(12, 'M12', 'Parts Request', 12, 0, 0, 0, 0),
(13, 'M13', 'Invoice', 13, 0, 0, 0, 0),
(14, 'M14', 'Admin Privileges', 14, 0, 0, 0, 0),
(15, 'SM21', 'All Customer', 2, 0, 0, 0, 0),
(16, 'SM22', 'All Vehicle', 2, 0, 0, 0, 0),
(17, 'SM23', 'Customer Synchronization ', 2, 0, 0, 0, 0),
(18, 'SM24', 'All Customer Outstanding', 2, 0, 0, 0, 0),
(19, 'SM25', 'Customer Active/Inactive', 2, 0, 0, 0, 0),
(20, 'SM51', 'Add Estimate', 5, 0, 0, 0, 0),
(21, 'SM52', 'All Estimates', 5, 0, 0, 0, 0),
(22, 'SM41', 'Add Sales Invoice', 4, 0, 0, 0, 0),
(23, 'SM42', 'All Sales Invoice', 4, 0, 0, 0, 0),
(24, 'SM43', 'Add Job Invoice', 4, 0, 0, 0, 0),
(25, 'SM44', 'All Job Temporary Invoice', 4, 0, 0, 0, 0),
(26, 'SM45', 'All Job Invoice', 4, 0, 0, 0, 0),
(27, 'M15', 'Cash Float', 15, 0, 0, 0, 0),
(28, 'SM161', 'Job Card Print', 16, 0, 0, 0, 0),
(29, 'SM162', 'Sale Invoice Print', 16, 0, 0, 0, 0),
(30, 'SM163', 'Job Sale Invoice Print', 16, 0, 0, 0, 0),
(31, 'SM101', 'Customer Payment', 10, 0, 0, 0, 0),
(32, 'SM102', 'Cancel Customer Payment', 10, 0, 0, 0, 0),
(33, 'SM103', 'Supplier Payment', 10, 0, 0, 0, 0),
(34, 'SM104', 'Cancel Supplier Payment', 10, 0, 0, 0, 0),
(35, 'SM131', 'Return Invoice', 13, 0, 0, 0, 0),
(36, 'SM132', 'All Return Invoice', 13, 0, 0, 0, 0),
(37, 'SM133', 'Cancel Pos Invoice', 13, 0, 0, 0, 0),
(39, 'SM134', 'Reprint Pos Invoice', 13, 0, 0, 0, 0),
(40, 'SM135', 'Cost Price', 17, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_permission_set`
--

CREATE TABLE `system_permission_set` (
  `id` int(11) NOT NULL,
  `per_code` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `per_class` varchar(250) NOT NULL,
  `module_id` int(11) NOT NULL,
  `is_view` int(11) NOT NULL DEFAULT 0,
  `is_add` int(11) NOT NULL DEFAULT 0,
  `is_edit` int(11) NOT NULL DEFAULT 0,
  `is_delete` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_permission_set`
--

INSERT INTO `system_permission_set` (`id`, `per_code`, `role_id`, `per_class`, `module_id`, `is_view`, `is_add`, `is_edit`, `is_delete`) VALUES
(1, 'M1', 1, 'Dashboard', 1, 1, 1, 1, 1),
(2, 'M2', 1, 'Customer', 2, 1, 1, 1, 1),
(3, 'SM21', 1, 'All Customer', 2, 1, 1, 1, 1),
(4, 'SM22', 1, 'All Vehicle', 2, 1, 1, 1, 1),
(5, 'SM23', 1, 'Customer Synchronization ', 2, 1, 1, 1, 1),
(6, 'SM24', 1, 'All Customer Outstanding', 2, 1, 1, 1, 1),
(7, 'SM25', 1, 'Customer Active/Inactive', 2, 1, 1, 1, 1),
(8, 'M3', 1, 'All Job Cards', 3, 1, 1, 1, 1),
(9, 'M4', 1, 'Invoice', 4, 1, 1, 1, 1),
(10, 'SM41', 1, 'Add Sales Invoice', 4, 1, 1, 1, 1),
(11, 'SM42', 1, 'All Sales Invoice', 4, 1, 1, 1, 1),
(12, 'SM43', 1, 'Add Job Invoice', 4, 1, 1, 1, 1),
(13, 'SM44', 1, 'All Job Temporary Invoice', 4, 1, 1, 1, 1),
(14, 'SM45', 1, 'All Job Invoice', 4, 1, 1, 1, 1),
(15, 'M5', 1, 'All Estimate', 5, 1, 1, 1, 1),
(16, 'SM51', 1, 'Add Estimate', 5, 1, 1, 1, 1),
(17, 'SM52', 1, 'All Estimates', 5, 1, 1, 1, 1),
(18, 'M6', 1, 'Products', 6, 1, 1, 1, 1),
(19, 'M7', 1, 'Master Forms', 7, 1, 1, 1, 1),
(20, 'M8', 1, 'Reporting', 8, 1, 1, 1, 1),
(21, 'M9', 1, 'Good Received Note', 9, 1, 1, 1, 1),
(22, 'M10', 1, 'Payment', 10, 1, 1, 1, 1),
(23, 'SM101', 1, 'Customer Payment', 10, 1, 1, 1, 1),
(24, 'SM102', 1, 'Cancel Customer Payment', 10, 1, 1, 1, 1),
(25, 'SM103', 1, 'Supplier Payment', 10, 1, 1, 1, 1),
(26, 'SM104', 1, 'Cancel Supplier Payment', 10, 1, 1, 1, 1),
(27, 'M11', 1, 'Purchase', 11, 1, 1, 1, 1),
(28, 'M12', 1, 'Parts Request', 12, 1, 1, 1, 1),
(29, 'M13', 1, 'Invoice', 13, 1, 1, 1, 1),
(30, 'SM131', 1, 'Return Invoice', 13, 1, 1, 1, 1),
(31, 'SM132', 1, 'All Return Invoice', 13, 1, 1, 1, 1),
(32, 'SM133', 1, 'Cancel Pos Invoice', 13, 1, 1, 1, 1),
(33, 'SM134', 1, 'Reprint Pos Invoice', 13, 1, 1, 1, 1),
(34, 'M14', 1, 'Admin Privileges', 14, 1, 1, 1, 1),
(35, 'M15', 1, 'Cash Float', 15, 1, 1, 1, 1),
(36, 'SM161', 1, 'Job Card Print', 16, 1, 1, 1, 1),
(37, 'SM162', 1, 'Sale Invoice Print', 16, 1, 1, 1, 1),
(38, 'SM163', 1, 'Job Sale Invoice Print', 16, 1, 1, 1, 1),
(39, 'M1', 4, 'Dashboard', 1, 1, 1, 1, 1),
(40, 'M2', 4, 'Customer', 2, 1, 1, 1, 1),
(41, 'SM21', 4, 'All Customer', 2, 1, 1, 1, 1),
(42, 'SM22', 4, 'All Vehicle', 2, 1, 1, 1, 1),
(43, 'SM23', 4, 'Customer Synchronization ', 2, 1, 1, 1, 1),
(44, 'SM24', 4, 'All Customer Outstanding', 2, 1, 1, 1, 1),
(45, 'SM25', 4, 'Customer Active/Inactive', 2, 1, 1, 1, 1),
(46, 'M3', 4, 'All Job Cards', 3, 1, 1, 1, 1),
(47, 'M4', 4, 'Invoice', 4, 1, 1, 1, 1),
(48, 'SM41', 4, 'Add Sales Invoice', 4, 1, 1, 1, 1),
(49, 'SM42', 4, 'All Sales Invoice', 4, 1, 1, 1, 1),
(50, 'SM43', 4, 'Add Job Invoice', 4, 1, 1, 1, 1),
(51, 'SM44', 4, 'All Job Temporary Invoice', 4, 1, 1, 1, 1),
(52, 'SM45', 4, 'All Job Invoice', 4, 1, 1, 1, 1),
(53, 'M5', 4, 'All Estimate', 5, 1, 1, 1, 1),
(54, 'SM51', 4, 'Add Estimate', 5, 1, 1, 1, 1),
(55, 'SM52', 4, 'All Estimates', 5, 1, 1, 1, 1),
(56, 'M6', 4, 'Products', 6, 1, 1, 1, 1),
(57, 'M7', 4, 'Master Forms', 7, 1, 1, 1, 1),
(58, 'M8', 4, 'Reporting', 8, 1, 0, 0, 1),
(59, 'M9', 4, 'Good Received Note', 9, 0, 0, 0, 0),
(60, 'M10', 4, 'Payment', 10, 1, 1, 1, 1),
(61, 'SM101', 4, 'Customer Payment', 10, 1, 1, 1, 1),
(62, 'SM102', 4, 'Cancel Customer Payment', 10, 1, 1, 1, 1),
(63, 'SM103', 4, 'Supplier Payment', 10, 1, 1, 1, 1),
(64, 'SM104', 4, 'Cancel Supplier Payment', 10, 1, 1, 1, 1),
(65, 'M11', 4, 'Purchase', 11, 1, 1, 1, 1),
(66, 'M12', 4, 'Parts Request', 12, 1, 1, 1, 1),
(67, 'M13', 4, 'Invoice', 13, 1, 1, 1, 1),
(68, 'SM131', 4, 'Return Invoice', 13, 1, 1, 1, 1),
(69, 'SM132', 4, 'All Return Invoice', 13, 1, 1, 1, 1),
(70, 'SM133', 4, 'Cancel Pos Invoice', 13, 1, 1, 1, 1),
(71, 'SM134', 4, 'Reprint Pos Invoice', 13, 1, 1, 1, 1),
(72, 'M14', 4, 'Admin Privileges', 14, 1, 1, 1, 1),
(73, 'M15', 4, 'Cash Float', 15, 1, 1, 1, 1),
(74, 'SM161', 4, 'Job Card Print', 16, 1, 1, 1, 1),
(75, 'SM162', 4, 'Sale Invoice Print', 16, 1, 1, 1, 1),
(76, 'SM163', 4, 'Job Sale Invoice Print', 16, 1, 1, 1, 1),
(77, 'M1', 2, 'Dashboard', 1, 1, 1, 1, 1),
(78, 'M2', 2, 'Customer', 2, 1, 1, 1, 1),
(79, 'SM21', 2, 'All Customer', 2, 1, 1, 1, 1),
(80, 'SM22', 2, 'All Vehicle', 2, 1, 1, 1, 1),
(81, 'SM23', 2, 'Customer Synchronization ', 2, 1, 1, 1, 1),
(82, 'SM24', 2, 'All Customer Outstanding', 2, 1, 1, 1, 1),
(83, 'SM25', 2, 'Customer Active/Inactive', 2, 1, 1, 1, 1),
(84, 'M3', 2, 'All Job Cards', 3, 1, 1, 1, 1),
(85, 'M4', 2, 'Invoice', 4, 1, 1, 1, 1),
(86, 'SM41', 2, 'Add Sales Invoice', 4, 1, 1, 1, 1),
(87, 'SM42', 2, 'All Sales Invoice', 4, 1, 1, 1, 1),
(88, 'SM43', 2, 'Add Job Invoice', 4, 1, 1, 1, 1),
(89, 'SM44', 2, 'All Job Temporary Invoice', 4, 1, 1, 1, 1),
(90, 'SM45', 2, 'All Job Invoice', 4, 1, 1, 1, 1),
(91, 'M5', 2, 'All Estimate', 5, 1, 1, 1, 1),
(92, 'SM51', 2, 'Add Estimate', 5, 1, 1, 1, 1),
(93, 'SM52', 2, 'All Estimates', 5, 1, 1, 1, 1),
(94, 'M6', 2, 'Products', 6, 1, 1, 1, 1),
(95, 'M7', 2, 'Master Forms', 7, 1, 1, 1, 1),
(96, 'M8', 2, 'Reporting', 8, 1, 1, 1, 1),
(97, 'M9', 2, 'Good Received Note', 9, 0, 0, 0, 1),
(98, 'M10', 2, 'Payment', 10, 1, 1, 1, 1),
(99, 'SM101', 2, 'Customer Payment', 10, 1, 1, 1, 1),
(100, 'SM102', 2, 'Cancel Customer Payment', 10, 1, 1, 1, 1),
(101, 'SM103', 2, 'Supplier Payment', 10, 1, 1, 1, 1),
(102, 'SM104', 2, 'Cancel Supplier Payment', 10, 1, 1, 1, 1),
(103, 'M11', 2, 'Purchase', 11, 1, 1, 1, 1),
(104, 'M12', 2, 'Parts Request', 12, 1, 1, 1, 1),
(105, 'M13', 2, 'Invoice', 13, 1, 1, 1, 1),
(106, 'SM131', 2, 'Return Invoice', 13, 1, 1, 1, 1),
(107, 'SM132', 2, 'All Return Invoice', 13, 1, 1, 1, 1),
(108, 'SM133', 2, 'Cancel Pos Invoice', 13, 1, 1, 1, 1),
(109, 'SM134', 2, 'Reprint Pos Invoice', 13, 1, 1, 1, 1),
(110, 'M14', 2, 'Admin Privileges', 14, 1, 1, 1, 1),
(111, 'M15', 2, 'Cash Float', 15, 1, 1, 1, 1),
(112, 'SM161', 2, 'Job Card Print', 16, 1, 1, 1, 1),
(113, 'SM162', 2, 'Sale Invoice Print', 16, 1, 1, 1, 1),
(114, 'SM163', 2, 'Job Sale Invoice Print', 16, 1, 1, 1, 1),
(115, 'M1', 3, 'Dashboard', 1, 1, 1, 1, 1),
(116, 'M2', 3, 'Customer', 2, 1, 1, 1, 1),
(117, 'SM21', 3, 'All Customer', 2, 1, 1, 1, 1),
(118, 'SM22', 3, 'All Vehicle', 2, 1, 1, 1, 1),
(119, 'SM23', 3, 'Customer Synchronization ', 2, 1, 1, 1, 1),
(120, 'SM24', 3, 'All Customer Outstanding', 2, 1, 1, 1, 1),
(121, 'SM25', 3, 'Customer Active/Inactive', 2, 1, 1, 1, 1),
(122, 'M3', 3, 'All Job Cards', 3, 1, 1, 1, 1),
(123, 'M4', 3, 'Invoice', 4, 1, 1, 1, 1),
(124, 'SM41', 3, 'Add Sales Invoice', 4, 1, 1, 1, 1),
(125, 'SM42', 3, 'All Sales Invoice', 4, 1, 1, 1, 1),
(126, 'SM43', 3, 'Add Job Invoice', 4, 1, 1, 1, 1),
(127, 'SM44', 3, 'All Job Temporary Invoice', 4, 1, 1, 1, 1),
(128, 'SM45', 3, 'All Job Invoice', 4, 1, 1, 1, 1),
(129, 'M5', 3, 'All Estimate', 5, 1, 1, 1, 1),
(130, 'SM51', 3, 'Add Estimate', 5, 1, 1, 1, 1),
(131, 'SM52', 3, 'All Estimates', 5, 1, 1, 1, 1),
(132, 'M6', 3, 'Products', 6, 1, 1, 1, 1),
(133, 'M7', 3, 'Master Forms', 7, 1, 1, 1, 1),
(134, 'M8', 3, 'Reporting', 8, 1, 1, 1, 1),
(135, 'M9', 3, 'Good Received Note', 9, 1, 1, 1, 1),
(136, 'M10', 3, 'Payment', 10, 1, 1, 1, 1),
(137, 'SM101', 3, 'Customer Payment', 10, 1, 1, 1, 1),
(138, 'SM102', 3, 'Cancel Customer Payment', 10, 1, 1, 1, 1),
(139, 'SM103', 3, 'Supplier Payment', 10, 1, 1, 1, 1),
(140, 'SM104', 3, 'Cancel Supplier Payment', 10, 1, 1, 1, 1),
(141, 'M11', 3, 'Purchase', 11, 1, 1, 1, 1),
(142, 'M12', 3, 'Parts Request', 12, 1, 1, 1, 1),
(143, 'M13', 3, 'Invoice', 13, 1, 1, 1, 1),
(144, 'SM131', 3, 'Return Invoice', 13, 1, 1, 1, 1),
(145, 'SM132', 3, 'All Return Invoice', 13, 1, 1, 1, 1),
(146, 'SM133', 3, 'Cancel Pos Invoice', 13, 1, 1, 1, 1),
(147, 'SM134', 3, 'Reprint Pos Invoice', 13, 1, 1, 1, 1),
(148, 'M14', 3, 'Admin Privileges', 14, 1, 1, 1, 1),
(149, 'M15', 3, 'Cash Float', 15, 1, 1, 1, 1),
(150, 'SM161', 3, 'Job Card Print', 16, 1, 1, 1, 1),
(151, 'SM162', 3, 'Sale Invoice Print', 16, 1, 1, 1, 1),
(152, 'SM163', 3, 'Job Sale Invoice Print', 16, 1, 1, 1, 1),
(153, 'M1', 5, 'Dashboard', 1, 1, 1, 1, 1),
(154, 'M2', 5, 'Customer', 2, 1, 1, 1, 1),
(155, 'SM21', 5, 'All Customer', 2, 1, 1, 1, 1),
(156, 'SM22', 5, 'All Vehicle', 2, 1, 1, 1, 1),
(157, 'SM23', 5, 'Customer Synchronization ', 2, 1, 1, 1, 1),
(158, 'SM24', 5, 'All Customer Outstanding', 2, 1, 1, 1, 1),
(159, 'SM25', 5, 'Customer Active/Inactive', 2, 1, 1, 1, 1),
(160, 'M3', 5, 'All Job Cards', 3, 1, 1, 1, 1),
(161, 'M4', 5, 'Invoice', 4, 1, 1, 1, 1),
(162, 'SM41', 5, 'Add Sales Invoice', 4, 1, 1, 1, 1),
(163, 'SM42', 5, 'All Sales Invoice', 4, 1, 1, 1, 1),
(164, 'SM43', 5, 'Add Job Invoice', 4, 1, 1, 1, 1),
(165, 'SM44', 5, 'All Job Temporary Invoice', 4, 1, 1, 1, 1),
(166, 'SM45', 5, 'All Job Invoice', 4, 1, 1, 1, 1),
(167, 'M5', 5, 'All Estimate', 5, 1, 1, 1, 1),
(168, 'SM51', 5, 'Add Estimate', 5, 1, 1, 1, 1),
(169, 'SM52', 5, 'All Estimates', 5, 1, 1, 1, 1),
(170, 'M6', 5, 'Products', 6, 1, 1, 1, 1),
(171, 'M7', 5, 'Master Forms', 7, 1, 1, 1, 1),
(172, 'M8', 5, 'Reporting', 8, 1, 1, 1, 1),
(173, 'M9', 5, 'Good Received Note', 9, 0, 0, 0, 1),
(174, 'M10', 5, 'Payment', 10, 1, 1, 1, 1),
(175, 'SM101', 5, 'Customer Payment', 10, 1, 1, 1, 1),
(176, 'SM102', 5, 'Cancel Customer Payment', 10, 1, 1, 1, 1),
(177, 'SM103', 5, 'Supplier Payment', 10, 1, 1, 1, 1),
(178, 'SM104', 5, 'Cancel Supplier Payment', 10, 1, 1, 1, 1),
(179, 'M11', 5, 'Purchase', 11, 1, 1, 1, 1),
(180, 'M12', 5, 'Parts Request', 12, 1, 1, 1, 1),
(181, 'M13', 5, 'Invoice', 13, 1, 1, 1, 1),
(182, 'SM131', 5, 'Return Invoice', 13, 1, 1, 1, 1),
(183, 'SM132', 5, 'All Return Invoice', 13, 1, 1, 1, 1),
(184, 'SM133', 5, 'Cancel Pos Invoice', 13, 1, 1, 1, 1),
(185, 'SM134', 5, 'Reprint Pos Invoice', 13, 1, 1, 1, 1),
(186, 'M14', 5, 'Admin Privileges', 14, 1, 1, 1, 1),
(187, 'M15', 5, 'Cash Float', 15, 1, 1, 1, 1),
(188, 'SM161', 5, 'Job Card Print', 16, 1, 1, 1, 1),
(189, 'SM162', 5, 'Sale Invoice Print', 16, 1, 1, 1, 1),
(190, 'SM163', 5, 'Job Sale Invoice Print', 16, 1, 1, 1, 1),
(191, 'M1', 7, 'Dashboard', 1, 1, 1, 1, 0),
(192, 'M2', 7, 'Customer', 2, 1, 0, 0, 0),
(193, 'SM21', 7, 'All Customer', 2, 1, 0, 0, 0),
(194, 'SM22', 7, 'All Vehicle', 2, 1, 0, 0, 0),
(195, 'SM23', 7, 'Customer Synchronization ', 2, 1, 0, 0, 0),
(196, 'SM24', 7, 'All Customer Outstanding', 2, 1, 0, 0, 0),
(197, 'SM25', 7, 'Customer Active/Inactive', 2, 1, 0, 0, 0),
(198, 'M3', 7, 'All Job Cards', 3, 1, 0, 0, 0),
(199, 'M4', 7, 'Invoice', 4, 1, 0, 0, 0),
(200, 'SM41', 7, 'Add Sales Invoice', 4, 1, 0, 0, 0),
(201, 'SM42', 7, 'All Sales Invoice', 4, 1, 0, 0, 0),
(202, 'SM43', 7, 'Add Job Invoice', 4, 1, 0, 0, 0),
(203, 'SM44', 7, 'All Job Temporary Invoice', 4, 1, 0, 0, 0),
(204, 'SM45', 7, 'All Job Invoice', 4, 1, 0, 0, 0),
(205, 'M5', 7, 'All Estimate', 5, 1, 0, 0, 0),
(206, 'SM51', 7, 'Add Estimate', 5, 1, 0, 0, 0),
(207, 'SM52', 7, 'All Estimates', 5, 1, 0, 0, 0),
(208, 'M6', 7, 'Products', 6, 1, 1, 0, 0),
(209, 'M7', 7, 'Master Forms', 7, 1, 1, 0, 0),
(210, 'M8', 7, 'Reporting', 8, 1, 1, 0, 0),
(211, 'M9', 7, 'Good Received Note', 9, 1, 1, 0, 0),
(212, 'M10', 7, 'Payment', 10, 1, 1, 0, 0),
(213, 'SM101', 7, 'Customer Payment', 10, 1, 1, 0, 0),
(214, 'SM102', 7, 'Cancel Customer Payment', 10, 1, 1, 0, 0),
(215, 'SM103', 7, 'Supplier Payment', 10, 1, 1, 0, 0),
(216, 'SM104', 7, 'Cancel Supplier Payment', 10, 1, 1, 0, 0),
(217, 'M11', 7, 'Purchase', 11, 0, 0, 0, 0),
(218, 'M12', 7, 'Parts Request', 12, 0, 0, 0, 0),
(219, 'M13', 7, 'Invoice', 13, 1, 1, 0, 0),
(220, 'SM131', 7, 'Return Invoice', 13, 1, 1, 0, 0),
(221, 'SM132', 7, 'All Return Invoice', 13, 1, 1, 0, 0),
(222, 'SM133', 7, 'Cancel Pos Invoice', 13, 1, 1, 0, 0),
(223, 'SM134', 7, 'Reprint Pos Invoice', 13, 1, 1, 0, 0),
(224, 'M14', 7, 'Admin Privileges', 14, 1, 1, 0, 0),
(225, 'M15', 7, 'Cash Float', 15, 1, 1, 0, 0),
(226, 'SM161', 7, 'Job Card Print', 16, 1, 1, 0, 0),
(227, 'SM162', 7, 'Sale Invoice Print', 16, 1, 1, 0, 0),
(228, 'SM163', 7, 'Job Sale Invoice Print', 16, 1, 1, 0, 0),
(229, 'SM135', 1, 'Cost Price', 17, 1, 1, 1, 1),
(230, 'SM135', 3, 'Cost Price', 17, 1, 1, 1, 1),
(231, 'SM135', 2, 'Cost Price', 17, 0, 0, 0, 1),
(232, 'SM135', 4, 'Cost Price', 17, 0, 0, 0, 1),
(233, 'SM135', 5, 'Cost Price', 17, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tempjobinvoicedtl`
--

CREATE TABLE `tempjobinvoicedtl` (
  `jobinvoicedtlid` int(11) NOT NULL,
  `JobInvNo` varchar(10) NOT NULL,
  `JobCardNo` varchar(10) NOT NULL,
  `EstLineNo` smallint(6) DEFAULT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JobOrder` tinyint(1) DEFAULT NULL,
  `JobType` varchar(255) DEFAULT NULL,
  `JobCode` varchar(255) DEFAULT NULL,
  `JobDescription` varchar(255) DEFAULT NULL,
  `JobQty` int(11) DEFAULT NULL,
  `JobCost` decimal(10,2) DEFAULT 0.00,
  `JobPrice` decimal(10,2) DEFAULT NULL,
  `JobIsVat` tinyint(1) DEFAULT 0,
  `JobIsNbt` tinyint(1) DEFAULT 0,
  `JobNbtRatio` decimal(5,2) DEFAULT 1.00,
  `JobTotalAmount` decimal(10,2) DEFAULT 0.00,
  `JobDiscount` decimal(10,2) DEFAULT 0.00,
  `JobVatAmount` decimal(10,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(10,2) DEFAULT 0.00,
  `JobNetAmount` decimal(10,2) DEFAULT 0.00,
  `JobDisValue` decimal(10,2) DEFAULT 0.00,
  `JobDisPercentage` decimal(10,2) DEFAULT 0.00,
  `JobDiscountType` tinyint(4) DEFAULT NULL,
  `JobinvoiceTimestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tempjobinvoicehed`
--

CREATE TABLE `tempjobinvoicehed` (
  `JobInvNo` varchar(10) NOT NULL DEFAULT '',
  `JobEstimateNo` varchar(10) DEFAULT NULL,
  `JobSupplimentry` varchar(10) DEFAULT NULL,
  `JobCardNo` varchar(10) NOT NULL DEFAULT '',
  `JInsCompany` int(11) DEFAULT NULL,
  `JCompanyCode` varchar(10) NOT NULL,
  `JobLocation` tinyint(4) DEFAULT NULL,
  `JCustomer` varchar(10) DEFAULT NULL,
  `JRegNo` varchar(40) DEFAULT NULL,
  `JobInvoiceDate` datetime NOT NULL,
  `CustomerPayment` decimal(20,2) DEFAULT 0.00,
  `JobAdvance` decimal(20,2) DEFAULT NULL,
  `JobTotalDiscount` decimal(20,2) DEFAULT 0.00,
  `JobCostAmount` decimal(20,2) DEFAULT 0.00,
  `JobNetAmount` decimal(20,2) DEFAULT 0.00,
  `JobTotalAmount` decimal(20,2) DEFAULT 0.00,
  `JobIsVatTotal` tinyint(1) DEFAULT 0,
  `JobIsNbtTotal` tinyint(1) DEFAULT 0,
  `JobNbtRatioTotal` decimal(5,2) DEFAULT 1.00,
  `JobVatAmount` decimal(20,2) DEFAULT 0.00,
  `JobNbtAmount` decimal(20,2) DEFAULT 0.00,
  `JobBankAcc` varchar(20) DEFAULT NULL,
  `JobBankAmount` decimal(20,2) DEFAULT NULL,
  `JobCashAmount` decimal(20,2) DEFAULT NULL,
  `JobCreditAmount` decimal(20,2) DEFAULT NULL,
  `JobCompanyAmount` decimal(20,2) DEFAULT NULL,
  `JobChequeAmount` decimal(20,2) DEFAULT NULL,
  `JobCardAmount` decimal(20,2) DEFAULT NULL,
  `ThirdCashAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCreditAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdChequeAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCardAmount` decimal(20,2) DEFAULT 0.00,
  `ThirdCustomerPayment` decimal(20,2) DEFAULT 0.00,
  `EstType` tinyint(4) NOT NULL,
  `JJobType` int(11) NOT NULL,
  `IsCompelte` tinyint(1) NOT NULL,
  `IsCancel` tinyint(1) NOT NULL,
  `IsEdit` tinyint(1) DEFAULT 0,
  `JobInvUser` tinyint(4) DEFAULT NULL,
  `InvoiceType` tinyint(1) DEFAULT 1,
  `IsInvoice` tinyint(1) DEFAULT 0,
  `InvRemark` longtext DEFAULT NULL,
  `IsPayment` tinyint(1) DEFAULT 0,
  `mileageout` int(11) DEFAULT NULL,
  `mileageoutUnit` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tempsalesfreeitem`
--

CREATE TABLE `tempsalesfreeitem` (
  `id` int(11) NOT NULL,
  `tempInvNo` varchar(25) NOT NULL,
  `productCode` varchar(25) NOT NULL,
  `productName` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unitOrCase` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tempsalesinvoicehed`
--

CREATE TABLE `tempsalesinvoicehed` (
  `tempInvId` int(11) NOT NULL,
  `tempInvNo` varchar(45) NOT NULL,
  `routeId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `grossAmount` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `date` datetime NOT NULL,
  `isInvoiceDiscount` tinyint(4) NOT NULL DEFAULT 0,
  `discountAmount` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `disPresantage` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `netTotal` decimal(20,6) NOT NULL DEFAULT 0.000000,
  `salesPerson` varchar(50) NOT NULL DEFAULT '0',
  `isActive` tinyint(4) NOT NULL DEFAULT 1,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `location` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tempsalesinvoicehed`
--

INSERT INTO `tempsalesinvoicehed` (`tempInvId`, `tempInvNo`, `routeId`, `customerId`, `grossAmount`, `date`, `isInvoiceDiscount`, `discountAmount`, `disPresantage`, `netTotal`, `salesPerson`, `isActive`, `status`, `location`) VALUES
(1, 'TSE0005', 1, 10001, 222.920000, '2025-08-12 13:21:21', 0, 0.000000, 0.000000, 222.920000, '1', 0, 1, 1),
(2, 'TSE0006', 1, 10002, 222.920000, '2025-08-12 13:22:27', 0, 0.000000, 0.000000, 222.920000, '1', 0, 1, 1),
(3, 'TSE0007', 1, 10001, 111.460000, '2025-08-12 13:30:51', 0, 0.000000, 0.000000, 111.460000, '1', 0, 1, 1),
(4, 'TSE0008', 1, 10002, 222.920000, '2025-08-12 13:34:09', 0, 0.000000, 0.000000, 222.920000, '1', 0, 1, 1),
(5, 'TSE0009', 1, 10001, 111.460000, '2025-08-12 15:00:12', 0, 0.000000, 0.000000, 111.460000, '1', 0, 1, 1),
(6, 'TSE0010', 1, 10001, 222.920000, '2025-08-12 15:04:06', 0, 0.000000, 0.000000, 222.920000, '1', 0, 1, 1),
(7, 'TSE0011', 1, 10016, 111.460000, '2025-08-12 17:25:37', 0, 0.000000, 0.000000, 111.460000, '1', 1, 1, 1),
(8, 'TSE0012', 1, 10002, 445.840000, '2025-08-13 08:02:44', 0, 0.000000, 0.000000, 445.840000, '1', 0, 1, 1),
(9, 'TSE0013', 1, 10001, 111.460000, '2025-08-13 11:12:20', 0, 0.000000, 0.000000, 111.460000, '1', 1, 1, 1),
(10, 'TSE0014', 1, 10001, 334.380000, '2025-08-13 11:35:27', 0, 0.000000, 0.000000, 334.380000, '1', 0, 1, 1),
(11, 'TSE0015', 1, 10015, 222.920000, '2025-08-13 11:37:13', 0, 0.000000, 0.000000, 222.920000, '1', 1, 1, 1),
(12, 'TSE0016', 1, 10001, 334.380000, '2025-08-13 11:45:41', 0, 0.000000, 0.000000, 334.380000, '1', 0, 1, 1),
(13, 'TSE0017', 1, 10021, 1300.000000, '2025-08-13 11:51:32', 0, 0.000000, 0.000000, 1300.000000, '1', 0, 1, 1),
(14, 'TSE0018', 1, 10001, 342.500000, '2025-08-13 12:25:46', 0, 0.000000, 0.000000, 342.500000, '1', 0, 1, 1),
(15, 'TSE0019', 1, 10001, 222.920000, '2025-08-13 12:28:57', 0, 0.000000, 0.000000, 222.920000, '1', 0, 1, 1),
(16, 'TSE0020', 1, 10002, 352.880000, '2025-08-13 12:31:59', 0, 0.000000, 0.000000, 352.880000, '1', 0, 1, 1),
(17, 'TSE0021', 1, 10002, 3975.120000, '2025-08-13 12:38:43', 0, 0.000000, 0.000000, 3975.120000, '1', 1, 1, 1),
(18, 'TSE0022', 1, 10039, 17482.000000, '2025-08-13 12:38:44', 0, 0.000000, 0.000000, 17482.000000, '1', 0, 1, 1),
(19, 'TSE0023', 1, 10003, 33571.000000, '2025-08-13 12:39:07', 0, 0.000000, 0.000000, 33571.000000, '1', 0, 1, 1),
(20, 'TSE0024', 1, 10015, 40323.120000, '2025-08-13 12:47:35', 0, 0.000000, 0.000000, 40323.120000, '1', 0, 1, 1),
(21, 'TSE0025', 1, 10001, 2038.130000, '2025-08-13 13:06:57', 0, 0.000000, 0.000000, 2038.130000, '1', 0, 1, 1),
(22, 'TSE0026', 1, 10002, 1226.060000, '2025-08-13 13:11:45', 0, 0.000000, 0.000000, 1226.060000, '1', 0, 1, 1),
(23, 'TSE0027', 2, 10053, 31144.200000, '2025-08-13 13:12:20', 0, 0.000000, 0.000000, 31144.200000, '1', 0, 1, 1),
(24, 'TSE0028', 2, 10046, 5301.360000, '2025-08-13 13:14:09', 0, 0.000000, 0.000000, 5301.360000, '1', 1, 1, 1),
(25, 'TSE0029', 1, 10002, 204.340000, '2025-08-13 13:14:52', 0, 0.000000, 0.000000, 204.340000, '1', 0, 1, 1),
(26, 'TSE0030', 2, 10046, 139816.630000, '2025-08-13 13:25:32', 0, 0.000000, 0.000000, 139816.630000, '1', 0, 1, 1),
(27, 'TSE0031', 1, 10001, 183.200000, '2025-08-13 13:43:25', 0, 0.000000, 0.000000, 183.200000, '1', 0, 1, 1),
(28, 'TSE0032', 1, 10002, 366.400000, '2025-08-19 15:32:37', 0, 0.000000, 0.000000, 366.400000, '1', 1, 1, 1),
(29, 'TSE0033', 1, 10002, 183.200000, '2025-08-19 16:01:33', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(30, 'TSE0034', 1, 10002, 274.800000, '2025-08-19 16:04:51', 0, 0.000000, 0.000000, 274.800000, '1', 1, 1, 1),
(31, 'TSE0035', 1, 10002, 183.200000, '2025-08-19 16:22:20', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(32, 'TSE0036', 1, 10002, 641.200000, '2025-08-20 10:21:49', 0, 0.000000, 0.000000, 641.200000, '1', 1, 1, 1),
(33, 'TSE0037', 1, 10002, 183.200000, '2025-08-20 10:46:56', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(34, 'TSE0038', 1, 10002, 274.800000, '2025-08-20 11:10:27', 0, 0.000000, 0.000000, 274.800000, '1', 1, 1, 1),
(35, 'TSE0039', 1, 10002, 183.200000, '2025-08-20 11:15:15', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(36, 'TSE0040', 1, 10002, 274.800000, '2025-08-20 11:38:34', 0, 0.000000, 0.000000, 274.800000, '1', 1, 1, 1),
(37, 'TSE0041', 1, 10002, 183.200000, '2025-08-20 11:41:09', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(38, 'TSE0042', 1, 10001, 187.250000, '2025-08-20 13:34:54', 0, 0.000000, 0.000000, 187.250000, '1', 1, 1, 1),
(39, 'TSE0043', 1, 10002, 183.200000, '2025-08-20 13:44:24', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(40, 'TSE0044', 1, 10002, 1465.600000, '2025-08-20 15:37:58', 0, 0.000000, 0.000000, 1465.600000, '1', 1, 1, 1),
(41, 'TSE0045', 1, 10002, 274.800000, '2025-08-20 15:51:28', 0, 0.000000, 0.000000, 274.800000, '1', 1, 1, 1),
(42, 'TSE0046', 1, 10002, 91.600000, '2025-08-20 15:53:26', 0, 0.000000, 0.000000, 91.600000, '1', 1, 1, 1),
(43, 'TSE0047', 1, 10002, 183.200000, '2025-08-20 15:58:08', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(44, 'TSE0048', 1, 10002, 183.200000, '2025-08-20 16:00:09', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(45, 'TSE0049', 1, 10002, 183.200000, '2025-08-20 16:25:30', 0, 0.000000, 0.000000, 183.200000, '1', 1, 1, 1),
(46, 'TSE0050', 1, 10002, 164.880000, '2025-08-21 15:04:57', 0, 0.000000, 0.000000, 164.880000, '1', 1, 1, 1),
(47, 'TSE0051', 1, 10002, 18320.000000, '2025-08-26 14:01:27', 0, 0.000000, 0.000000, 18320.000000, '1', 0, 1, 1),
(48, 'TSE0052', 1, 10001, 1099.200000, '2025-08-26 14:18:55', 0, 0.000000, 0.000000, 1099.200000, '1', 0, 1, 1),
(49, 'TSE0053', 1, 10002, 91.600000, '2025-08-27 13:53:44', 0, 0.000000, 0.000000, 91.600000, '1', 1, 1, 1),
(50, 'TSE0054', 1, 10001, 274.800000, '2025-08-27 13:59:54', 0, 0.000000, 0.000000, 274.800000, '1', 0, 1, 1),
(51, 'TSE0055', 1, 10002, 0.000000, '2025-08-27 14:44:16', 0, 0.000000, 0.000000, 0.000000, '1', 1, 1, 1),
(52, 'TSE0056', 1, 10002, 613.720000, '2025-08-27 14:45:44', 0, 0.000000, 0.000000, 613.720000, '1', 1, 1, 1),
(53, 'TSE0057', 1, 10002, 163.200000, '2025-08-27 15:42:33', 0, 0.000000, 0.000000, 163.200000, '1', 1, 1, 1),
(54, 'TSE0058', 1, 10002, 87.020000, '2025-08-27 15:44:45', 0, 0.000000, 0.000000, 87.020000, '1', 1, 1, 1),
(55, 'TSE0059', 1, 10003, 549.600000, '2025-08-27 15:49:19', 0, 0.000000, 0.000000, 549.600000, '1', 0, 1, 1),
(56, 'TSE0060', 1, 10015, 2325.760000, '2025-08-28 16:25:45', 0, 0.000000, 0.000000, 2325.760000, '1', 0, 1, 1),
(57, 'TSE0061', 1, 10015, 824.400000, '2025-08-28 17:03:48', 0, 0.000000, 0.000000, 824.400000, '1', 0, 1, 1),
(58, 'TSE0062', 1, 10065, 1455.600000, '2025-08-29 12:37:32', 0, 0.000000, 0.000000, 1455.600000, '1', 0, 1, 1),
(59, 'TSE0063', 1, 10065, 5417.140000, '2025-08-29 15:37:55', 0, 0.000000, 0.000000, 5417.140000, '1', 1, 1, 1),
(60, 'TSE0064', 1, 10065, 2750.000000, '2025-08-30 14:17:52', 0, 0.000000, 0.000000, 2750.000000, '1', 0, 1, 1),
(61, 'TSE0065', 1, 10065, 2750.000000, '2025-08-30 14:25:34', 0, 0.000000, 0.000000, 2750.000000, '1', 0, 1, 1),
(62, 'TSE0066', 12, 10071, 2600.000000, '2025-09-01 14:57:13', 0, 0.000000, 0.000000, 2600.000000, '1', 0, 1, 1),
(63, 'TSE0067', 12, 10071, 4080.000000, '2025-09-01 15:29:24', 0, 0.000000, 0.000000, 4080.000000, '1', 0, 1, 1),
(64, 'TSE0068', 12, 10071, 1066.250000, '2025-09-02 11:50:46', 0, 0.000000, 0.000000, 1066.250000, '1', 1, 1, 1),
(65, 'TSE0069', 12, 10071, 1182.750000, '2025-09-02 11:53:52', 0, 0.000000, 0.000000, 1182.750000, '1', 1, 1, 1),
(66, 'TSE0070', 12, 10071, 2600.000000, '2025-09-02 12:05:53', 1, 260.000000, 10.000000, 2340.000000, '1', 0, 1, 1),
(67, 'TSE0071', 12, 10071, 260.000000, '2025-09-02 13:16:20', 0, 0.000000, 0.000000, 260.000000, '1', 1, 1, 1),
(68, 'TSE0072', 12, 10071, 3700.000000, '2025-09-02 15:18:15', 0, 0.000000, 0.000000, 3700.000000, '1', 0, 1, 1),
(69, 'TSE0073', 1, 10001, 20688.500000, '2025-09-03 08:27:17', 0, 0.000000, 0.000000, 20688.500000, '1', 1, 1, 1),
(70, 'TSE0074', 1, 10018, 195227.960000, '2025-09-03 08:38:34', 0, 0.000000, 0.000000, 195227.960000, '1', 0, 1, 1),
(71, 'TSE0075', 1, 10002, 458.000000, '2025-09-03 09:42:25', 0, 0.000000, 0.000000, 458.000000, '1', 1, 1, 1),
(72, 'TSE0076', 1, 10002, 861.200000, '2025-09-03 10:19:43', 0, 0.000000, 0.000000, 861.200000, '1', 1, 1, 1),
(73, 'TSE0077', 1, 10002, 5055.900000, '2025-09-03 11:49:41', 0, 0.000000, 0.000000, 5055.900000, '1', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tempsalesinvoiceheddtl`
--

CREATE TABLE `tempsalesinvoiceheddtl` (
  `id` int(11) NOT NULL,
  `tempInvoiceNo` varchar(45) NOT NULL,
  `productCode` varchar(45) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `unitOrCase` varchar(45) NOT NULL,
  `paymentType` int(11) NOT NULL DEFAULT 0,
  `saleQuantity` int(11) NOT NULL,
  `unitPrice` decimal(10,2) NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `isDiscount` tinyint(2) NOT NULL DEFAULT 0,
  `disAmount` decimal(10,2) DEFAULT 0.00,
  `disPresantage` decimal(10,2) DEFAULT 0.00,
  `totalNetAmount` decimal(10,2) NOT NULL,
  `isActive` tinyint(2) NOT NULL DEFAULT 1,
  `disType` varchar(50) DEFAULT NULL,
  `salesCostPrice` double(10,2) DEFAULT NULL,
  `SalesFreeQty` int(11) DEFAULT NULL,
  `IsReturn` int(11) NOT NULL DEFAULT 0,
  `ReturnType` int(11) DEFAULT NULL,
  `SalesReturnQty` int(11) DEFAULT NULL,
  `PriceLevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tempsalesinvoiceheddtl`
--

INSERT INTO `tempsalesinvoiceheddtl` (`id`, `tempInvoiceNo`, `productCode`, `productName`, `unitOrCase`, `paymentType`, `saleQuantity`, `unitPrice`, `totalAmount`, `isDiscount`, `disAmount`, `disPresantage`, `totalNetAmount`, `isActive`, `disType`, `salesCostPrice`, `SalesFreeQty`, `IsReturn`, `ReturnType`, `SalesReturnQty`, `PriceLevel`) VALUES
(1, 'TSE0005', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(2, 'TSE0005', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(3, 'TSE0006', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(4, 'TSE0006', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(5, 'TSE0007', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 2, 0, 0, NULL, 1),
(6, 'TSE0008', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(7, 'TSE0008', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(8, 'TSE0009', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(9, 'TSE0010', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(10, 'TSE0010', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 3, NULL, 1),
(11, 'TSE0011', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(12, 'TSE0012', '100007', 'PEPSI - 250ML', 'UNIT', 1, 2, 111.00, 222.00, 0, 0.00, 0.00, 222.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(13, 'TSE0012', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(14, 'TSE0012', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(15, 'TSE0013', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 1, 0, 0, NULL, 1),
(16, 'TSE0014', '100007', 'PEPSI - 250ML', 'UNIT', 1, 2, 111.00, 222.00, 0, 0.00, 0.00, 222.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(17, 'TSE0014', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(18, 'TSE0015', '100010', '7UP - 250ML', 'UNIT', 1, 2, 111.00, 222.00, 0, 0.00, 0.00, 222.00, 1, '', 104.29, 1, 0, 0, NULL, 1),
(19, 'TSE0015', '100007', 'PEPSI - 250ML', 'UNIT', 1, 0, 111.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 104.29, 1, 0, 0, NULL, 1),
(20, 'TSE0016', '100007', 'PEPSI - 250ML', 'UNIT', 1, 2, 111.00, 222.00, 0, 0.00, 0.00, 222.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(21, 'TSE0016', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(22, 'TSE0017', '100047', 'P01', 'UNIT', 1, 10, 130.00, 1300.00, 0, 0.00, 0.00, 1300.00, 1, '', 100.00, 1, 0, 2, NULL, 1),
(23, 'TSE0018', '100063', 'WATER - 500ML', 'UNIT', 1, 1, 60.00, 60.00, 0, 0.00, 0.00, 60.00, 1, '', 56.00, 0, 0, 0, NULL, 1),
(24, 'TSE0018', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 1, 282.00, 282.00, 0, 0.00, 0.00, 282.00, 1, '', 250.00, 0, 1, 2, NULL, 1),
(25, 'TSE0019', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(26, 'TSE0019', '100026', 'MONTAN DEW - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 3, NULL, 1),
(27, 'TSE0020', '100005', 'PEPSI - 400ML', 'UNIT', 1, 1, 187.00, 187.00, 0, 0.00, 0.00, 187.00, 1, '', 155.54, 0, 1, 3, NULL, 1),
(28, 'TSE0020', '100020', 'MIRINDA - 400ML', 'UNIT', 1, 1, 165.00, 165.00, 0, 0.00, 0.00, 165.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(29, 'TSE0021', '100020', 'MIRINDA - 400ML', 'CASE', 1, 1, 165.00, 3975.00, 0, 0.00, 0.00, 3975.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(30, 'TSE0022', '100010', '7UP - 250ML', 'UNIT', 1, 15, 111.00, 1671.00, 0, 0.00, 0.00, 1671.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(31, 'TSE0022', '100007', 'PEPSI - 250ML', 'UNIT', 1, 15, 111.00, 1671.00, 0, 0.00, 0.00, 1671.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(32, 'TSE0022', '100054', 'GINGER BEER - 250ML', 'UNIT', 1, 10, 92.00, 928.00, 0, 0.00, 0.00, 928.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(33, 'TSE0022', '100051', 'CREAM SODA - 1000ML', 'UNIT', 1, 0, 252.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 236.00, 3, 0, 0, NULL, 1),
(34, 'TSE0022', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 250.00, 0, 0, 0, NULL, 1),
(35, 'TSE0022', '100049', 'CREAM SODA - 250ML', 'UNIT', 1, 10, 92.00, 928.00, 0, 0.00, 0.00, 928.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(36, 'TSE0022', '100026', 'MONTAN DEW - 250ML', 'UNIT', 1, 10, 111.00, 1114.00, 0, 0.00, 0.00, 1114.00, 1, '', 104.29, 1, 0, 0, NULL, 1),
(37, 'TSE0022', '100022', 'MIRINDA - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 263.50, 0, 0, 0, NULL, 1),
(38, 'TSE0022', '100023', 'MIRINDA - 1500ML', 'UNIT', 1, 6, 372.00, 2232.00, 0, 0.00, 0.00, 2232.00, 1, '', 350.50, 0, 0, 0, NULL, 1),
(39, 'TSE0022', '100052', 'CREAM SODA - 1500ML', 'UNIT', 1, 6, 361.00, 2166.00, 0, 0.00, 0.00, 2166.00, 1, '', 341.00, 0, 0, 0, NULL, 1),
(40, 'TSE0023', '100007', 'PEPSI - 250ML', 'UNIT', 1, 15, 111.00, 1671.00, 0, 0.00, 0.00, 1671.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(41, 'TSE0023', '100018', 'MIRINDA - 250ML', 'UNIT', 1, 60, 111.00, 6687.00, 0, 0.00, 0.00, 6687.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(42, 'TSE0023', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 250.00, 0, 0, 0, NULL, 1),
(43, 'TSE0023', '100010', '7UP - 250ML', 'UNIT', 1, 15, 111.00, 1671.00, 0, 0.00, 0.00, 1671.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(44, 'TSE0023', '100049', 'CREAM SODA - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(45, 'TSE0023', '100022', 'MIRINDA - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 263.50, 0, 0, 0, NULL, 1),
(46, 'TSE0023', '100058', 'ZINGO - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(47, 'TSE0023', '100052', 'CREAM SODA - 1500ML', 'UNIT', 1, 1, 361.00, 361.00, 0, 0.00, 0.00, 361.00, 1, '', 341.00, 1, 0, 0, NULL, 1),
(48, 'TSE0023', '100060', 'ZINGO - 1000ML', 'UNIT', 1, 12, 252.00, 3030.00, 0, 0.00, 0.00, 3030.00, 1, '', 236.00, 0, 0, 0, NULL, 1),
(49, 'TSE0023', '100026', 'MONTAN DEW - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(50, 'TSE0023', '100023', 'MIRINDA - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 0, 0, 0, NULL, 1),
(51, 'TSE0024', '100005', 'PEPSI - 400ML', 'UNIT', 1, 48, 187.00, 8988.00, 0, 0.00, 0.00, 8988.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(52, 'TSE0024', '100012', '7UP - 400ML', 'UNIT', 1, 24, 187.00, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(53, 'TSE0024', '100020', 'MIRINDA - 400ML', 'UNIT', 1, 24, 165.00, 3975.00, 0, 0.00, 0.00, 3975.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(54, 'TSE0024', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 250.00, 5, 0, 0, NULL, 1),
(55, 'TSE0024', '100059', 'ZINGO - 400ML', 'UNIT', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(56, 'TSE0024', '100014', '7UP - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 263.50, 0, 0, 0, NULL, 1),
(57, 'TSE0024', '100055', 'GINGER BEER - 400ML', 'UNIT', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(58, 'TSE0024', '100022', 'MIRINDA - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 263.50, 0, 0, 0, NULL, 1),
(59, 'TSE0024', '100051', 'CREAM SODA - 1000ML', 'UNIT', 1, 12, 253.00, 3045.00, 0, 0.00, 0.00, 3045.00, 1, '', 236.00, 0, 0, 0, NULL, 1),
(60, 'TSE0024', '100060', 'ZINGO - 1000ML', 'UNIT', 1, 12, 253.00, 3045.00, 0, 0.00, 0.00, 3045.00, 1, '', 236.00, 0, 0, 0, NULL, 1),
(61, 'TSE0025', '100005', 'PEPSI - 400ML', 'UNIT', 1, 10, 187.00, 1872.00, 0, 0.00, 0.00, 1872.00, 1, '', 155.54, 1, 0, 0, NULL, 1),
(62, 'TSE0025', '100050', 'CREAM SODA - 400ML', 'UNIT', 1, 0, 138.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 130.00, 1, 0, 0, NULL, 1),
(63, 'TSE0025', '100020', 'MIRINDA - 400ML', 'UNIT', 1, 1, 165.00, 165.00, 0, 0.00, 0.00, 165.00, 1, '', 155.54, 0, 1, 2, NULL, 1),
(64, 'TSE0026', '100007', 'PEPSI - 250ML', 'UNIT', 1, 10, 111.00, 1114.00, 0, 0.00, 0.00, 1114.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(65, 'TSE0026', '100010', '7UP - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 3, NULL, 1),
(66, 'TSE0027', '100009', '7UP - 200ML', 'UNIT', 1, 48, 91.00, 4396.00, 0, 0.00, 0.00, 4396.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(67, 'TSE0027', '100007', 'PEPSI - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 1, 0, 0, NULL, 1),
(68, 'TSE0027', '100017', 'MIRINDA - 200ML', 'UNIT', 1, 24, 91.00, 2198.00, 0, 0.00, 0.00, 2198.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(69, 'TSE0027', '100054', 'GINGER BEER - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 1, 0, 0, NULL, 1),
(70, 'TSE0027', '100008', 'PEPSI - 200ML', 'UNIT', 1, 48, 91.00, 4396.00, 0, 0.00, 0.00, 4396.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(71, 'TSE0027', '100005', 'PEPSI - 400ML', 'UNIT', 1, 24, 187.00, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(72, 'TSE0027', '100001', 'PEPSI - 1500ML', 'UNIT', 1, 3, 372.00, 1116.00, 0, 0.00, 0.00, 1116.00, 1, '', 350.50, 0, 1, 3, NULL, 1),
(73, 'TSE0027', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 2, 282.00, 564.00, 0, 0.00, 0.00, 564.00, 1, '', 250.00, 0, 1, 2, NULL, 1),
(74, 'TSE0027', '100022', 'MIRINDA - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 0, 0.00, 0.00, 3384.00, 1, '', 263.50, 1, 0, 0, NULL, 1),
(75, 'TSE0027', '100015', '7UP - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 1, 0, 0, NULL, 1),
(76, 'TSE0028', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 12, 282.00, 3384.00, 1, 203.00, 6.00, 3180.00, 1, '%', 250.00, 0, 0, 0, NULL, 1),
(77, 'TSE0028', '100015', '7UP - 1500ML', 'UNIT', 1, 6, 372.00, 2232.00, 1, 111.00, 5.00, 2120.00, 1, '%', 350.50, 0, 0, 0, NULL, 1),
(78, 'TSE0029', '100007', 'PEPSI - 250ML', 'UNIT', 1, 1, 111.00, 111.00, 0, 0.00, 0.00, 111.00, 1, '', 104.29, 0, 1, 2, NULL, 1),
(79, 'TSE0029', '100049', 'CREAM SODA - 250ML', 'UNIT', 1, 1, 92.00, 92.00, 0, 0.00, 0.00, 92.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(80, 'TSE0030', '100008', 'PEPSI - 200ML', 'UNIT', 1, 48, 91.00, 4396.00, 0, 0.00, 0.00, 4396.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(81, 'TSE0030', '100009', '7UP - 200ML', 'UNIT', 1, 24, 91.00, 2198.00, 0, 0.00, 0.00, 2198.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(82, 'TSE0030', '100017', 'MIRINDA - 200ML', 'UNIT', 1, 24, 91.00, 2198.00, 0, 0.00, 0.00, 2198.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(83, 'TSE0030', '100025', 'MONTAN DEW - 200ML', 'UNIT', 1, 0, 91.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 24, 0, 0, NULL, 1),
(84, 'TSE0030', '100048', 'CREAM SODA - 200ML', 'UNIT', 1, 24, 91.00, 2198.00, 0, 0.00, 0.00, 2198.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(85, 'TSE0030', '100053', 'GINGER BEER - 200ML', 'UNIT', 1, 24, 91.00, 2198.00, 0, 0.00, 0.00, 2198.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(86, 'TSE0030', '100005', 'PEPSI - 400ML', 'UNIT', 1, 24, 187.00, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(87, 'TSE0030', '100012', '7UP - 400ML', 'UNIT', 1, 24, 187.00, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(88, 'TSE0030', '100020', 'MIRINDA - 400ML', 'UNIT', 1, 24, 165.00, 3975.00, 0, 0.00, 0.00, 3975.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(89, 'TSE0030', '100055', 'GINGER BEER - 400ML', 'UNIT', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(90, 'TSE0030', '100004', 'PEPSI - 2000ML', 'UNIT', 1, 18, 448.00, 8074.00, 1, 240.00, 2.00, 7834.00, 1, 'Amount', 423.00, 0, 0, 0, NULL, 1),
(91, 'TSE0030', '100050', 'CREAM SODA - 400ML', 'UNIT', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(92, 'TSE0030', '100016', '7UP - 2000ML', 'UNIT', 1, 18, 448.00, 8074.00, 1, 240.00, 2.00, 7834.00, 1, 'Amount', 422.78, 0, 0, 0, NULL, 1),
(93, 'TSE0030', '100061', 'SODA (EV) - 400ML', 'UNIT', 1, 24, 92.00, 2208.00, 0, 0.00, 0.00, 2208.00, 1, '', 87.00, 2, 0, 0, NULL, 1),
(94, 'TSE0030', '100059', 'ZINGO - 400ML', 'UNIT', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(95, 'TSE0030', '100024', 'MIRINDA - 2000ML', 'UNIT', 1, 9, 448.00, 4037.00, 1, 120.00, 2.00, 3917.00, 1, 'Amount', 422.78, 0, 0, 0, NULL, 1),
(96, 'TSE0030', '100018', 'MIRINDA - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(97, 'TSE0030', '100049', 'CREAM SODA - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(98, 'TSE0030', '100026', 'MONTAN DEW - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(99, 'TSE0030', '100010', '7UP - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(100, 'TSE0030', '100007', 'PEPSI - 250ML', 'UNIT', 1, 30, 111.00, 3343.00, 0, 0.00, 0.00, 3343.00, 1, '', 104.29, 0, 0, 0, NULL, 1),
(101, 'TSE0030', '100054', 'GINGER BEER - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(102, 'TSE0030', '100058', 'ZINGO - 250ML', 'UNIT', 1, 30, 92.00, 2786.00, 0, 0.00, 0.00, 2786.00, 1, '', 87.00, 0, 0, 0, NULL, 1),
(103, 'TSE0030', '100002', 'PEPSI - 1000ML', 'UNIT', 1, 24, 282.00, 6768.00, 1, 473.00, 7.00, 6294.00, 1, '%', 250.00, 0, 0, 0, NULL, 1),
(104, 'TSE0030', '100014', '7UP - 1000ML', 'UNIT', 1, 24, 282.00, 6768.00, 1, 473.00, 7.00, 6294.00, 1, '%', 263.50, 0, 0, 0, NULL, 1),
(105, 'TSE0030', '100022', 'MIRINDA - 1000ML', 'UNIT', 1, 24, 282.00, 6768.00, 1, 473.00, 7.00, 6294.00, 1, '%', 263.50, 0, 0, 0, NULL, 1),
(106, 'TSE0030', '100051', 'CREAM SODA - 1000ML', 'UNIT', 1, 12, 253.00, 3045.00, 1, 213.00, 7.00, 2831.00, 1, '%', 236.00, 0, 0, 0, NULL, 1),
(107, 'TSE0030', '100056', 'GINGER BEER - 1000ML', 'UNIT', 1, 12, 252.00, 3030.00, 1, 212.00, 7.00, 2817.00, 1, '%', 236.00, 0, 0, 0, NULL, 1),
(108, 'TSE0030', '100060', 'ZINGO - 1000ML', 'UNIT', 1, 12, 252.00, 3030.00, 1, 212.00, 7.00, 2817.00, 1, '%', 236.00, 0, 0, 0, NULL, 1),
(109, 'TSE0030', '100062', 'SODA (EV) - 1000ML', 'UNIT', 1, 12, 156.00, 1877.00, 0, 0.00, 0.00, 1877.00, 1, '', 147.00, 1, 0, 0, NULL, 1),
(110, 'TSE0030', '100064', 'WATER - 1000ML', 'UNIT', 1, 30, 86.00, 2600.00, 0, 0.00, 0.00, 2600.00, 1, '', 80.00, 15, 0, 0, NULL, 1),
(111, 'TSE0030', '100063', 'WATER - 500ML', 'UNIT', 1, 24, 60.00, 1452.00, 0, 0.00, 0.00, 1452.00, 1, '', 56.00, 0, 0, 0, NULL, 1),
(112, 'TSE0030', '100065', 'WATER - 1500ML', 'UNIT', 1, 24, 113.00, 2719.00, 0, 0.00, 0.00, 2719.00, 1, '', 103.00, 0, 0, 0, NULL, 1),
(113, 'TSE0030', '100001', 'PEPSI - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 5, 0, 0, NULL, 1),
(114, 'TSE0030', '100015', '7UP - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 0, 0, 0, NULL, 1),
(115, 'TSE0030', '100023', 'MIRINDA - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 0, 0, 0, NULL, 1),
(116, 'TSE0030', '100029', 'MONTAN DEW - 1500ML', 'UNIT', 1, 12, 372.00, 4464.00, 0, 0.00, 0.00, 4464.00, 1, '', 350.50, 0, 0, 0, NULL, 1),
(117, 'TSE0030', '100052', 'CREAM SODA - 1500ML', 'UNIT', 1, 12, 361.00, 4332.00, 0, 0.00, 0.00, 4332.00, 1, '', 341.00, 0, 0, 0, NULL, 1),
(118, 'TSE0030', '100004', 'PEPSI - 2000ML', 'UNIT', 1, 2, 448.00, 897.00, 0, 0.00, 0.00, 897.00, 1, '', 423.00, 0, 1, 2, NULL, 1),
(119, 'TSE0030', '100010', '7UP - 250ML', 'UNIT', 1, 10, 111.00, 1114.00, 0, 0.00, 0.00, 1114.00, 1, '', 104.29, 0, 1, 3, NULL, 1),
(120, 'TSE0031', '100008', 'PEPSI - 200ML', 'UNIT', 1, 1, 91.00, 91.00, 0, 0.00, 0.00, 91.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(121, 'TSE0031', '100053', 'GINGER BEER - 200ML', 'UNIT', 1, 1, 91.00, 91.00, 0, 0.00, 0.00, 91.00, 1, '', 85.00, 0, 1, 2, NULL, 1),
(122, 'TSE0032', '100008', 'PEPSI - 200ML', '0', 1, 4, 91.00, 91.00, 0, 0.00, 0.00, 366.00, 1, '', 85.00, 2, 0, 0, NULL, 1),
(123, 'TSE0033', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.00, 91.00, 0, 0.00, 0.00, 183.00, 1, '', 85.00, 1, 0, 0, NULL, 1),
(124, 'TSE0034', '100009', '7UP - 200ML', '0', 1, 3, 91.00, 91.00, 0, 0.00, 0.00, 274.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(125, 'TSE0035', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.00, 183.00, 0, 0.00, 0.00, 183.00, 1, '', 85.00, 1, 0, 0, NULL, 1),
(126, 'TSE0036', '100009', '7UP - 200ML', '0', 1, 7, 91.00, 0.00, 0, 0.00, 0.00, 641.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(127, 'TSE0037', '100009', '7UP - 200ML', '0', 1, 2, 91.00, 0.00, 0, 0.00, 0.00, 183.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(128, 'TSE0038', '100008', 'PEPSI - 200ML', '0', 1, 3, 91.00, 0.00, 0, 0.00, 0.00, 274.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(129, 'TSE0039', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.00, 0.00, 0, 0.00, 0.00, 183.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(130, 'TSE0040', '100008', 'PEPSI - 200ML', '0', 1, 3, 91.00, 0.00, 0, 0.00, 0.00, 274.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(131, 'TSE0041', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.00, 0.00, 0, 0.00, 0.00, 183.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(132, 'TSE0042', '100005', 'PEPSI - 400ML', 'UNIT', 1, 1, 187.00, 187.00, 0, 0.00, 0.00, 187.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(133, 'TSE0043', '100008', 'PEPSI - 200ML', 'UNIT', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 366.40, 1, '', 85.00, 0, 0, 0, NULL, 1),
(134, 'TSE0044', '100008', 'PEPSI - 200ML', '0', 1, 8, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '%', 85.00, 1, 0, 0, NULL, 1),
(135, 'TSE0044', '100009', '7UP - 200ML', '0', 1, 3, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(136, 'TSE0044', '100025', 'MONTAN DEW - 200ML', '0', 1, 5, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(137, 'TSE0045', '100008', 'PEPSI - 200ML', '0', 1, 3, 91.60, 0.00, 0, 0.00, 0.00, 274.80, 1, '%', 85.00, 1, 0, 0, NULL, 1),
(138, 'TSE0046', '100008', 'PEPSI - 200ML', 'UNIT', 1, 1, 91.60, 91.60, 0, 0.00, 0.00, 91.60, 1, '', 85.00, 0, 0, 0, NULL, 1),
(139, 'TSE0047', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 0.00, 0, 0.00, 0.00, 183.20, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(140, 'TSE0048', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 0.00, 0, 0.00, 0.00, 183.20, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(141, 'TSE0049', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(142, 'TSE0050', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 164.88, 1, 0.00, 10.00, 164.88, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(143, 'TSE0051', '100008', 'PEPSI - 200ML', '0', 1, 100, 91.60, 9160.00, 0, 0.00, 0.00, 9160.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(144, 'TSE0051', '100017', 'MIRINDA - 200ML', '0', 1, 100, 91.60, 9160.00, 0, 0.00, 0.00, 9160.00, 1, '', 85.00, 0, 0, 0, NULL, 1),
(145, 'TSE0052', '100008', 'PEPSI - 200ML', '0', 1, 10, 91.60, 824.40, 1, 0.00, 10.00, 824.40, 1, '%', 85.00, 1, 0, 0, NULL, 1),
(146, 'TSE0052', '100009', '7UP - 200ML', '0', 1, 3, 91.60, 274.80, 0, 0.00, 0.00, 274.80, 1, '', 85.00, 0, 0, 0, NULL, 1),
(147, 'TSE0053', '100008', 'PEPSI - 200ML', '0', 1, 1, 91.60, 91.60, 0, 0.00, 0.00, 91.60, 1, '', 85.00, 0, 1, 2, NULL, 1),
(148, 'TSE0054', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 1, 0, 0, NULL, 1),
(149, 'TSE0054', '100009', '7UP - 200ML', '0', 1, 1, 91.60, 91.60, 0, 0.00, 0.00, 91.60, 1, '', 85.00, 0, 1, 2, NULL, 1),
(150, 'TSE0055', '100008', 'PEPSI - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 2, 0, 0, NULL, 1),
(151, 'TSE0056', '100008', 'PEPSI - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 2, 0, 0, NULL, 1),
(152, 'TSE0056', '100017', 'MIRINDA - 200ML', '0', 1, 3, 91.60, 247.32, 1, 0.00, 10.00, 247.32, 1, '%', 85.00, 1, 0, 0, NULL, 1),
(153, 'TSE0056', '100048', 'CREAM SODA - 200ML', '0', 1, 4, 91.60, 366.40, 0, 0.00, 0.00, 366.40, 1, '', 85.00, 0, 1, 2, NULL, 1),
(154, 'TSE0057', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 163.20, 1, 20.00, 0.00, 163.20, 1, 'AMT', 85.00, 0, 0, 0, NULL, 1),
(155, 'TSE0058', '100008', 'PEPSI - 200ML', '0', 1, 1, 91.60, 87.02, 1, 0.00, 5.00, 87.02, 1, '%', 85.00, 0, 0, 0, NULL, 1),
(156, 'TSE0059', '100009', '7UP - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 0, 0, NULL, 1),
(157, 'TSE0059', '100008', 'PEPSI - 200ML', '0', 1, 1, 91.60, 91.60, 0, 0.00, 0.00, 91.60, 1, '', 85.00, 0, 0, 0, NULL, 1),
(158, 'TSE0059', '100057', 'ZINGO - 200ML', '0', 1, 3, 91.60, 274.80, 0, 0.00, 0.00, 274.80, 1, '', 85.00, 1, 0, 0, NULL, 1),
(159, 'TSE0060', '100008', 'PEPSI - 200ML', '0', 1, 4, 91.60, 366.40, 0, 0.00, 0.00, 366.40, 1, '', 85.00, 1, 0, 0, NULL, 1),
(160, 'TSE0060', '100070', 'ORANGE CRUSH', '0', 1, 5, 120.00, 600.00, 0, 0.00, 0.00, 600.00, 1, '', 60.00, 0, 1, 2, NULL, 1),
(161, 'TSE0060', '100053', 'GINGER BEER - 200ML', '0', 1, 4, 91.60, 329.76, 1, 0.00, 10.00, 329.76, 1, '%', 85.00, 5, 0, 0, NULL, 1),
(162, 'TSE0060', '100017', 'MIRINDA - 200ML', '0', 1, 6, 91.60, 549.60, 0, 0.00, 0.00, 549.60, 1, '', 85.00, 2, 0, 0, NULL, 1),
(163, 'TSE0060', '100070', 'ORANGE CRUSH', '0', 1, 4, 120.00, 480.00, 0, 0.00, 0.00, 480.00, 1, '', 60.00, 2, 0, 0, NULL, 1),
(164, 'TSE0060', '100025', 'MONTAN DEW - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 8, 0, 0, NULL, 1),
(165, 'TSE0061', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 0, 0, NULL, 1),
(166, 'TSE0061', '100009', '7UP - 200ML', '0', 1, 5, 91.60, 458.00, 0, 0.00, 0.00, 458.00, 1, '', 85.00, 1, 0, 0, NULL, 1),
(167, 'TSE0061', '100025', 'MONTAN DEW - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 3, 0, 0, NULL, 1),
(168, 'TSE0061', '100048', 'CREAM SODA - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 1, 2, NULL, 1),
(169, 'TSE0062', '100008', 'PEPSI - 200ML', '0', 1, 5, 91.60, 448.00, 1, 10.00, 0.00, 448.00, 1, 'AMT', 85.00, 2, 0, 0, NULL, 1),
(170, 'TSE0062', '100008', 'PEPSI - 200ML', '0', 1, 1, 91.60, 91.60, 0, 0.00, 0.00, 91.60, 1, '', 85.00, 0, 1, 2, NULL, 1),
(171, 'TSE0062', '100009', '7UP - 200ML', '0', 1, 10, 91.60, 732.80, 1, 0.00, 20.00, 732.80, 1, '%', 85.00, 3, 0, 2, NULL, 1),
(172, 'TSE0062', '100017', 'MIRINDA - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 10, 0, 0, NULL, 1),
(173, 'TSE0062', '100009', '7UP - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 1, 3, NULL, 1),
(174, 'TSE0063', '100008', 'PEPSI - 200ML', '0', 1, 10, 91.60, 916.00, 0, 0.00, 0.00, 916.00, 1, '', 85.00, 2, 0, 0, NULL, 1),
(175, 'TSE0063', '100009', '7UP - 200ML', '0', 1, 10, 91.60, 916.00, 0, 0.00, 0.00, 916.00, 1, '', 85.00, 2, 0, 0, NULL, 1),
(176, 'TSE0063', '100057', 'ZINGO - 200ML', '0', 1, 5, 91.60, 425.94, 1, 0.00, 7.00, 425.94, 1, '%', 85.00, 2, 0, 0, NULL, 1),
(177, 'TSE0063', '100070', 'ORANGE CRUSH', '0', 1, 10, 100.00, 950.00, 1, 50.00, 0.00, 950.00, 1, 'AMT', 60.00, 8, 0, 0, NULL, 1),
(178, 'TSE0063', '100025', 'MONTAN DEW - 200ML', '0', 1, 10, 91.60, 906.00, 1, 10.00, 0.00, 906.00, 1, 'AMT', 85.00, 2, 0, 0, NULL, 1),
(179, 'TSE0063', '100053', 'GINGER BEER - 200ML', '0', 1, 5, 91.60, 412.20, 1, 0.00, 10.00, 412.20, 1, '%', 85.00, 2, 0, 0, NULL, 1),
(180, 'TSE0063', '100048', 'CREAM SODA - 200ML', '0', 1, 10, 91.60, 891.00, 1, 25.00, 0.00, 891.00, 1, 'AMT', 85.00, 2, 0, 0, NULL, 1),
(181, 'TSE0064', '100072', 'PINEAPPLE', '0', 1, 5, 100.00, 500.00, 0, 0.00, 0.00, 500.00, 1, '', 50.00, 0, 0, 0, NULL, 1),
(182, 'TSE0064', '100073', 'GRAPES', '0', 1, 5, 200.00, 1000.00, 0, 0.00, 0.00, 1000.00, 1, '', 100.00, 0, 0, 0, NULL, 1),
(183, 'TSE0064', '100074', 'PEARS', '0', 1, 5, 250.00, 1250.00, 0, 0.00, 0.00, 1250.00, 1, '', 100.00, 0, 0, 0, NULL, 1),
(184, 'TSE0065', '100072', 'PINEAPPLE', '0', 1, 5, 100.00, 500.00, 0, 0.00, 0.00, 500.00, 1, '', 50.00, 2, 0, 0, NULL, 1),
(185, 'TSE0065', '100074', 'PEARS', '0', 1, 5, 250.00, 1250.00, 0, 0.00, 0.00, 1250.00, 1, '', 100.00, 2, 0, 0, NULL, 1),
(186, 'TSE0065', '100073', 'GRAPES', '0', 1, 5, 200.00, 1000.00, 0, 0.00, 0.00, 1000.00, 1, '', 100.00, 2, 0, 0, NULL, 1),
(187, 'TSE0066', '100077', 'GUAVA', '0', 1, 10, 260.00, 2600.00, 0, 0.00, 0.00, 2600.00, 1, '', 160.00, 0, 0, 0, NULL, 1),
(188, 'TSE0066', '100077', 'GUAVA', '0', 1, 0, 250.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 160.00, 5, 0, 0, NULL, 1),
(189, 'TSE0067', '100077', 'GUAVA', '0', 1, 10, 260.00, 2600.00, 0, 0.00, 0.00, 2600.00, 1, '', 160.00, 0, 0, 0, NULL, 1),
(190, 'TSE0067', '100077', 'GUAVA', '0', 1, 0, 250.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 160.00, 5, 0, 0, NULL, 1),
(191, 'TSE0067', '100073', 'GRAPES', '0', 1, 5, 200.00, 980.00, 1, 20.00, 0.00, 980.00, 1, 'AMT', 100.00, 0, 0, 0, NULL, 1),
(192, 'TSE0067', '100075', 'BANANA', '0', 1, 5, 100.00, 500.00, 0, 0.00, 0.00, 500.00, 1, '', 50.00, 0, 1, 2, NULL, 1),
(193, 'TSE0068', '100075', 'BANANA', '0', 1, 10, 120.00, 1071.00, 1, 10.00, 10.00, 1071.00, 1, '%', 70.00, 0, 0, 0, NULL, 1),
(194, 'TSE0068', '100076', 'AVACADO', '0', 1, 0, 200.00, -4.75, 1, 5.00, 5.00, -4.75, 1, '%', 120.00, 5, 0, 0, NULL, 1),
(195, 'TSE0069', '100077', 'GUAVA', '0', 1, 5, 250.00, 1182.75, 1, 5.00, 5.00, 1182.75, 1, '%', 160.00, 5, 1, 2, NULL, 1),
(196, 'TSE0070', '100077', 'GUAVA', '0', 1, 0, 250.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 160.00, 5, 0, 0, NULL, 1),
(197, 'TSE0070', '100077', 'GUAVA', '0', 1, 10, 260.00, 2600.00, 0, 0.00, 0.00, 2600.00, 1, '', 160.00, 2, 0, 0, NULL, 1),
(198, 'TSE0071', '100077', 'GUAVA', '0', 1, 1, 260.00, 260.00, 0, 0.00, 0.00, 260.00, 1, '', 160.00, 0, 1, 2, NULL, 1),
(199, 'TSE0071', '100075', 'BANANA', '0', 1, 0, 110.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 80.00, 5, 1, 3, NULL, 1),
(200, 'TSE0072', '100077', 'GUAVA', '0', 1, 10, 260.00, 2600.00, 0, 0.00, 0.00, 2600.00, 1, '', 160.00, 0, 0, 0, NULL, 1),
(201, 'TSE0072', '100077', 'GUAVA', '0', 1, 0, 250.00, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 160.00, 5, 0, 0, NULL, 1),
(202, 'TSE0072', '100076', 'AVACADO', '0', 1, 5, 220.00, 1100.00, 0, 0.00, 0.00, 1100.00, 1, '', 120.00, 0, 1, 2, NULL, 1),
(203, 'TSE0073', '100009', '7UP - 200ML', '0', 1, 48, 91.60, 4396.80, 0, 0.00, 0.00, 4396.80, 1, '', 85.00, 0, 0, 0, NULL, 1),
(204, 'TSE0073', '100017', 'MIRINDA - 200ML', '0', 1, 24, 91.60, 2198.40, 0, 0.00, 0.00, 2198.40, 1, '', 85.00, 0, 0, 0, NULL, 1),
(205, 'TSE0073', '100008', 'PEPSI - 200ML', '0', 1, 48, 91.60, 4396.80, 0, 0.00, 0.00, 4396.80, 1, '', 85.00, 0, 0, 0, NULL, 1),
(206, 'TSE0073', '100057', 'ZINGO - 200ML', '0', 1, 20, 91.60, 1832.00, 0, 0.00, 0.00, 1832.00, 1, '', 85.00, 0, 1, 3, NULL, 1),
(207, 'TSE0073', '100048', 'CREAM SODA - 200ML', '0', 1, 0, 91.60, 0.00, 0, 0.00, 0.00, 0.00, 1, '', 85.00, 24, 0, 0, NULL, 1),
(208, 'TSE0073', '100005', 'PEPSI - 400ML', '0', 1, 24, 187.25, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(209, 'TSE0073', '100005', 'PEPSI - 400ML', '0', 1, 18, 187.25, 3370.50, 0, 0.00, 0.00, 3370.50, 1, '', 155.54, 0, 1, 2, NULL, 1),
(210, 'TSE0074', '100008', 'PEPSI - 200ML', '0', 1, 120, 91.60, 10992.00, 0, 0.00, 0.00, 10992.00, 1, '', 85.00, 24, 0, 0, NULL, 1),
(211, 'TSE0074', '100009', '7UP - 200ML', '0', 1, 240, 91.60, 21984.00, 0, 0.00, 0.00, 21984.00, 1, '', 85.00, 48, 0, 0, NULL, 1),
(212, 'TSE0074', '100005', 'PEPSI - 400ML', '0', 1, 24, 187.25, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(213, 'TSE0074', '100012', '7UP - 400ML', '0', 1, 24, 187.25, 4494.00, 0, 0.00, 0.00, 4494.00, 1, '', 155.54, 0, 0, 0, NULL, 1),
(214, 'TSE0074', '100020', 'MIRINDA - 400ML', '0', 1, 48, 165.63, 7950.24, 0, 0.00, 0.00, 7950.24, 1, '', 155.54, 0, 0, 0, NULL, 1),
(215, 'TSE0074', '100050', 'CREAM SODA - 400ML', '0', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(216, 'TSE0074', '100004', 'PEPSI - 2000ML', '0', 1, 18, 448.56, 7834.08, 1, 240.00, 0.00, 7834.08, 1, 'AMT', 423.00, 0, 0, 0, NULL, 1),
(217, 'TSE0074', '100061', 'SODA (EV) - 400ML', '0', 1, 24, 92.00, 2208.00, 0, 0.00, 0.00, 2208.00, 1, '', 87.00, 2, 0, 0, NULL, 1),
(218, 'TSE0074', '100055', 'GINGER BEER - 400ML', '0', 1, 24, 138.00, 3312.00, 0, 0.00, 0.00, 3312.00, 1, '', 130.00, 0, 0, 0, NULL, 1),
(219, 'TSE0074', '100024', 'MIRINDA - 2000ML', '0', 1, 18, 448.56, 7834.08, 1, 240.00, 0.00, 7834.08, 1, 'AMT', 422.78, 0, 0, 0, NULL, 1),
(220, 'TSE0074', '100007', 'PEPSI - 250ML', '0', 1, 150, 111.46, 15548.67, 1, 0.00, 7.00, 15548.67, 1, '%', 104.29, 0, 0, 0, NULL, 1),
(221, 'TSE0074', '100049', 'CREAM SODA - 250ML', '0', 1, 60, 92.88, 5182.70, 1, 0.00, 7.00, 5182.70, 1, '%', 87.00, 0, 0, 0, NULL, 1),
(222, 'TSE0074', '100016', '7UP - 2000ML', '0', 1, 18, 448.56, 7834.08, 1, 240.00, 0.00, 7834.08, 1, 'AMT', 422.78, 0, 0, 0, NULL, 1),
(223, 'TSE0074', '100054', 'GINGER BEER - 250ML', '0', 1, 30, 92.88, 2591.35, 1, 0.00, 7.00, 2591.35, 1, '%', 87.00, 0, 0, 0, NULL, 1),
(224, 'TSE0074', '100002', 'PEPSI - 1000ML', '0', 1, 24, 282.00, 6768.00, 0, 0.00, 0.00, 6768.00, 1, '', 250.00, 2, 0, 0, NULL, 1),
(225, 'TSE0074', '100014', '7UP - 1000ML', '0', 1, 60, 282.00, 16920.00, 0, 0.00, 0.00, 16920.00, 1, '', 263.50, 5, 0, 0, NULL, 1),
(226, 'TSE0074', '100010', '7UP - 250ML', '0', 1, 60, 111.46, 6219.47, 1, 0.00, 7.00, 6219.47, 1, '%', 104.29, 0, 0, 0, NULL, 1),
(227, 'TSE0074', '100001', 'PEPSI - 1500ML', '0', 1, 48, 372.00, 16427.52, 1, 0.00, 8.00, 16427.52, 1, '%', 350.50, 0, 0, 0, NULL, 1),
(228, 'TSE0074', '100064', 'WATER - 1000ML', '0', 1, 75, 86.67, 6500.25, 0, 0.00, 0.00, 6500.25, 1, '', 80.00, 15, 0, 0, NULL, 1),
(229, 'TSE0074', '100015', '7UP - 1500ML', '0', 1, 60, 372.00, 20534.40, 1, 0.00, 8.00, 20534.40, 1, '%', 350.50, 0, 0, 0, NULL, 1),
(230, 'TSE0074', '100001', 'PEPSI - 1500ML', '0', 1, 5, 372.00, 1860.00, 0, 0.00, 0.00, 1860.00, 1, '', 350.50, 0, 1, 3, NULL, 1),
(231, 'TSE0074', '100051', 'CREAM SODA - 1000ML', '0', 1, 48, 252.50, 12120.00, 0, 0.00, 0.00, 12120.00, 1, '', 236.00, 4, 0, 0, NULL, 1),
(232, 'TSE0074', '100004', 'PEPSI - 2000ML', '0', 1, 2, 448.56, 897.12, 0, 0.00, 0.00, 897.12, 1, '', 423.00, 0, 1, 2, NULL, 1),
(233, 'TSE0074', '100002', 'PEPSI - 1000ML', '0', 1, 3, 282.00, 846.00, 0, 0.00, 0.00, 846.00, 1, '', 250.00, 0, 1, 2, NULL, 1),
(234, 'TSE0074', '100014', '7UP - 1000ML', '0', 1, 2, 282.00, 564.00, 0, 0.00, 0.00, 564.00, 1, '', 263.50, 0, 1, 3, NULL, 1),
(235, 'TSE0075', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 1, 2, NULL, 1),
(236, 'TSE0075', '100017', 'MIRINDA - 200ML', '0', 1, 3, 91.60, 274.80, 0, 0.00, 0.00, 274.80, 1, '', 85.00, 0, 1, 3, NULL, 1),
(237, 'TSE0076', '100008', 'PEPSI - 200ML', '0', 1, 2, 91.60, 183.20, 0, 0.00, 0.00, 183.20, 1, '', 85.00, 0, 1, 2, NULL, 1),
(238, 'TSE0076', '100076', 'AVACADO', '0', 1, 1, 220.00, 220.00, 0, 0.00, 0.00, 220.00, 1, '', 120.00, 0, 0, 0, NULL, 1),
(239, 'TSE0076', '100017', 'MIRINDA - 200ML', '0', 1, 5, 91.60, 458.00, 0, 0.00, 0.00, 458.00, 1, '', 85.00, 0, 1, 3, NULL, 1),
(240, 'TSE0077', '100010', '7UP - 250ML', '0', 1, 15, 111.46, 1671.90, 0, 0.00, 0.00, 1671.90, 1, '', 104.29, 0, 0, 0, NULL, 1),
(241, 'TSE0077', '100002', 'PEPSI - 1000ML', '0', 1, 6, 282.00, 1692.00, 0, 0.00, 0.00, 1692.00, 1, '', 250.00, 1, 0, 0, NULL, 1),
(242, 'TSE0077', '100014', '7UP - 1000ML', '0', 1, 6, 282.00, 1692.00, 0, 0.00, 0.00, 1692.00, 1, '', 263.50, 0, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE `title` (
  `TitleId` int(11) NOT NULL,
  `TitleName` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `title`
--

INSERT INTO `title` (`TitleId`, `TitleName`) VALUES
(1, 'Mr'),
(2, 'Mrs'),
(3, 'Miss'),
(4, 'Other'),
(5, 'Dr'),
(6, 'Rev'),
(7, 'Ven'),
(8, 'M/S'),
(9, 'Gen'),
(10, 'Ms'),
(11, 'Capt'),
(12, 'Atte');

-- --------------------------------------------------------

--
-- Table structure for table `transactiontypes`
--

CREATE TABLE `transactiontypes` (
  `TransactionCode` int(11) NOT NULL,
  `TransactionName` varchar(60) NOT NULL,
  `IsExpenses` tinyint(4) NOT NULL,
  `Remark` varchar(100) NOT NULL,
  `IsActive` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactiontypes`
--

INSERT INTO `transactiontypes` (`TransactionCode`, `TransactionName`, `IsExpenses`, `Remark`, `IsActive`) VALUES
(1, 'Tea', 1, 'Tea', 1),
(2, 'payment', 0, 'payment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(10) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(10) UNSIGNED NOT NULL,
  `last_login` int(10) UNSIGNED DEFAULT NULL,
  `active` tinyint(3) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` tinyint(4) DEFAULT 1,
  `com_id` tinyint(1) DEFAULT 1,
  `role` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `location`, `com_id`, `role`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$j/8Trh8yBJsy8SBXyvP4WeWyyecPpVIEDoWOXL2BTLSJ4Kv0dGdsa', '', 'admin@nsoft.lk', '', NULL, NULL, 'vgQqYhkQFG8EVW4Gy4xoA.', 1268889823, 1756884197, 1, 'Sathutu', 'Lanka', 'L.39, Saddathissapura,', '+94 77 846 3849', 1, 1, 1),
(18, '112.134.245.122', '', '$2y$08$wd17gqLCqZop8TutKfieyuQd4n843lVBxjcJT6mY0XLSqamLLjTbq', NULL, 'tharaka@mytechnology.lk', NULL, NULL, NULL, NULL, 1682399427, 1684300911, 1, 'HASHAN', 'THARAKA', 'My Technology (PVT) LTD. Nugegoda', '0775069317', 2, 2, 3),
(19, '112.134.247.249', '', '$2y$08$YRnlGrhK6Y4d/1w3uz8/quU8SSECBXd0XhWne3qc0dGGhC9dvZ.Ni', NULL, 'iranga@mytechnology.lk', NULL, NULL, NULL, NULL, 1682436111, 1684816114, 1, 'IRANGA', 'KEERTHIRATHNE', 'My Technology (PVT) LTD. Nugegoda', '0705879034', 2, 2, 2),
(20, '124.43.241.6', '', '$2y$08$09n2z5S2AktzXDlUSSA2mebl8zFX4YJwMSe.pgq/M4MhDtFgwKHh.', NULL, 'buddhini@mytechnology.lk', NULL, NULL, NULL, 'G40XtE6PHxyyKTK19y1FzO', 1682698379, 1694849092, 1, 'BUDDHINI', 'PRASADINEE', 'My Technology (PVT) LTD. Nugegoda', '0701090941', 2, 2, 4),
(21, '112.134.246.128', '', '$2y$08$YEWK4EPMVxezEKC/E89TQOfCwlCyBFnZJt5uUlJzuvbG6myQbvKii', NULL, 'lakshitha2@mytechnology.lk', NULL, NULL, NULL, 'LvDAlUEfpjS32dp4QpOSke', 1686219862, 1694849058, 1, 'Lakshitha', 'Weerasinghe', 'My Technology (PVT) LTD. Pepiliyana', '0789497878', 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(86, 1, 1),
(82, 18, 1),
(83, 19, 1),
(84, 20, 1),
(85, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vehicledetail`
--

CREATE TABLE `vehicledetail` (
  `VehicleId` int(11) NOT NULL,
  `CusCode` varchar(11) NOT NULL,
  `contactName` varchar(50) DEFAULT NULL,
  `RegNo` varchar(50) NOT NULL,
  `ChassisNo` varchar(55) DEFAULT NULL,
  `EngineNo` varchar(11) DEFAULT NULL,
  `Make` int(11) DEFAULT NULL,
  `Model` int(11) DEFAULT NULL,
  `Color` varchar(50) DEFAULT NULL,
  `FuelType` tinyint(4) DEFAULT NULL,
  `ManufactureYear` year(4) NOT NULL,
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_company`
--

CREATE TABLE `vehicle_company` (
  `VComId` int(11) NOT NULL,
  `VComName` varchar(100) DEFAULT NULL,
  `VComCategory` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warrantydetails`
--

CREATE TABLE `warrantydetails` (
  `AppNo` int(11) NOT NULL,
  `InvLocation` smallint(6) NOT NULL,
  `InvNo` varchar(10) NOT NULL,
  `InvProductCode` varchar(18) NOT NULL,
  `InvSerialNo` varchar(20) NOT NULL,
  `WarrantyPeriod` int(11) NOT NULL,
  `WarrantyEndDate` date NOT NULL,
  `ClaimProcess` tinyint(4) NOT NULL,
  `ClaimDate` date NOT NULL,
  `WarrantyRemark` varchar(200) NOT NULL,
  `IsClaimComplete` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_typs`
--

CREATE TABLE `warranty_typs` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `warranty_typs`
--

INSERT INTO `warranty_typs` (`id`, `type`) VALUES
(1, '1 Month'),
(2, '2 Month'),
(3, '3 Month'),
(4, '6 Month'),
(5, '1 Year'),
(6, '2 Years'),
(7, '3 Years'),
(8, '7 Days'),
(9, 'No Warranty');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`AccNo`);

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`DepNo`);

--
-- Indexes for table `account_type_sub`
--
ALTER TABLE `account_type_sub`
  ADD PRIMARY KEY (`DepNo`,`SubDepNo`);

--
-- Indexes for table `acc_gurantee`
--
ALTER TABLE `acc_gurantee`
  ADD PRIMARY KEY (`AccNo`,`GuranteeNic`,`GuranteeNo`);

--
-- Indexes for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`BankCode`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `body_color`
--
ALTER TABLE `body_color`
  ADD PRIMARY KEY (`bodycolor_id`);

--
-- Indexes for table `branch_address`
--
ALTER TABLE `branch_address`
  ADD PRIMARY KEY (`loc_id`);

--
-- Indexes for table `cancelcustomerpayment`
--
ALTER TABLE `cancelcustomerpayment`
  ADD PRIMARY KEY (`AppNo`,`Location`,`CancelNo`);

--
-- Indexes for table `cancelgrn`
--
ALTER TABLE `cancelgrn`
  ADD PRIMARY KEY (`AppNo`,`CancelNo`,`Location`);

--
-- Indexes for table `cancelinvoice`
--
ALTER TABLE `cancelinvoice`
  ADD PRIMARY KEY (`AppNo`,`CancelNo`,`Location`);

--
-- Indexes for table `canceljobinvoice`
--
ALTER TABLE `canceljobinvoice`
  ADD PRIMARY KEY (`AppNo`,`CancelNo`,`Location`);

--
-- Indexes for table `canceljobinvpayment`
--
ALTER TABLE `canceljobinvpayment`
  ADD PRIMARY KEY (`AppNo`,`CancelNo`,`Location`);

--
-- Indexes for table `cancelsupplierpayment`
--
ALTER TABLE `cancelsupplierpayment`
  ADD PRIMARY KEY (`AppNo`,`Location`,`CancelNo`);

--
-- Indexes for table `canceltranser`
--
ALTER TABLE `canceltranser`
  ADD PRIMARY KEY (`AppNo`,`CancelNo`,`Location`);

--
-- Indexes for table `cashflot`
--
ALTER TABLE `cashflot`
  ADD PRIMARY KEY (`AppNo`,`Location`,`FlotNo`);

--
-- Indexes for table `cashierbalancesheet`
--
ALTER TABLE `cashierbalancesheet`
  ADD PRIMARY KEY (`AppNo`,`Location`,`ID`,`SystemUser`);

--
-- Indexes for table `cashinout`
--
ALTER TABLE `cashinout`
  ADD PRIMARY KEY (`AppNo`,`Location`,`InOutID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`DepCode`,`SubDepCode`,`CategoryCode`);

--
-- Indexes for table `charges_type`
--
ALTER TABLE `charges_type`
  ADD PRIMARY KEY (`charge_id`);

--
-- Indexes for table `chequedetails`
--
ALTER TABLE `chequedetails`
  ADD PRIMARY KEY (`AutoID`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_function`
--
ALTER TABLE `class_function`
  ADD PRIMARY KEY (`function_id`);

--
-- Indexes for table `clearproductlog`
--
ALTER TABLE `clearproductlog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clearseriallog`
--
ALTER TABLE `clearseriallog`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `codegenerate`
--
ALTER TABLE `codegenerate`
  ADD PRIMARY KEY (`FormName`,`FormCode`,`AutoNumber`);

--
-- Indexes for table `code_genarate`
--
ALTER TABLE `code_genarate`
  ADD PRIMARY KEY (`RefId`);

--
-- Indexes for table `comission`
--
ALTER TABLE `comission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`CompanyID`);

--
-- Indexes for table `companycreditinvoicedetails`
--
ALTER TABLE `companycreditinvoicedetails`
  ADD PRIMARY KEY (`AppNo`,`ComInvoiceNo`,`ComLocation`,`ComCusCode`);

--
-- Indexes for table `creditcardtypes`
--
ALTER TABLE `creditcardtypes`
  ADD PRIMARY KEY (`Card_Type`);

--
-- Indexes for table `creditgrndetails`
--
ALTER TABLE `creditgrndetails`
  ADD PRIMARY KEY (`AppNo`,`GRNNo`,`Location`,`SupCode`);

--
-- Indexes for table `creditinvoicedetails`
--
ALTER TABLE `creditinvoicedetails`
  ADD PRIMARY KEY (`AppNo`,`Type`,`InvoiceDate`,`InvoiceNo`,`Location`,`CusCode`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CusCode`);

--
-- Indexes for table `customerorderdtl`
--
ALTER TABLE `customerorderdtl`
  ADD PRIMARY KEY (`PO_Id`);

--
-- Indexes for table `customerorderhed`
--
ALTER TABLE `customerorderhed`
  ADD PRIMARY KEY (`AppNo`,`PO_No`,`PO_Location`);

--
-- Indexes for table `customerorderpayment`
--
ALTER TABLE `customerorderpayment`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `customeroutstanding`
--
ALTER TABLE `customeroutstanding`
  ADD PRIMARY KEY (`CusCode`);

--
-- Indexes for table `customerpaymentdtl`
--
ALTER TABLE `customerpaymentdtl`
  ADD PRIMARY KEY (`AppNo`,`Location`,`CusPayNo`,`Mode`);

--
-- Indexes for table `customerpaymenthed`
--
ALTER TABLE `customerpaymenthed`
  ADD PRIMARY KEY (`AppNo`,`CusPayNo`,`Location`,`CusCode`);

--
-- Indexes for table `customer_account_type`
--
ALTER TABLE `customer_account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_avc`
--
ALTER TABLE `customer_avc`
  ADD PRIMARY KEY (`cc`);

--
-- Indexes for table `customer_category`
--
ALTER TABLE `customer_category`
  ADD PRIMARY KEY (`CusCatId`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`CusTypeId`);

--
-- Indexes for table `customer_types`
--
ALTER TABLE `customer_types`
  ADD PRIMARY KEY (`CusTypeId`);

--
-- Indexes for table `cus_document`
--
ALTER TABLE `cus_document`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`DepCode`);

--
-- Indexes for table `down_paid`
--
ALTER TABLE `down_paid`
  ADD PRIMARY KEY (`PaymentId`,`PaymentType`,`InvNo`);

--
-- Indexes for table `down_payment_dtl`
--
ALTER TABLE `down_payment_dtl`
  ADD PRIMARY KEY (`InvNo`,`DwPayType`);

--
-- Indexes for table `editinvoices`
--
ALTER TABLE `editinvoices`
  ADD PRIMARY KEY (`Editid`);

--
-- Indexes for table `employeeroutes`
--
ALTER TABLE `employeeroutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_type`
--
ALTER TABLE `emp_type`
  ADD PRIMARY KEY (`EmpTypeNo`);

--
-- Indexes for table `estimatedtl`
--
ALTER TABLE `estimatedtl`
  ADD PRIMARY KEY (`estimatedtlid`);

--
-- Indexes for table `estimatehed`
--
ALTER TABLE `estimatehed`
  ADD PRIMARY KEY (`EstJobCardNo`,`EstimateNo`,`Supplimentry`);

--
-- Indexes for table `estimate_jobtype`
--
ALTER TABLE `estimate_jobtype`
  ADD PRIMARY KEY (`EstimateJobNo`);

--
-- Indexes for table `estimate_type`
--
ALTER TABLE `estimate_type`
  ADD PRIMARY KEY (`EstimateTypeNo`);

--
-- Indexes for table `estimate_worktype`
--
ALTER TABLE `estimate_worktype`
  ADD PRIMARY KEY (`estimate_type_id`);

--
-- Indexes for table `est_document`
--
ALTER TABLE `est_document`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `fuel_type`
--
ALTER TABLE `fuel_type`
  ADD PRIMARY KEY (`fuel_typeid`);

--
-- Indexes for table `goodsreceivenotedtl`
--
ALTER TABLE `goodsreceivenotedtl`
  ADD PRIMARY KEY (`AppNo`,`GRN_No`,`GRN_Product`,`SerialNo`);

--
-- Indexes for table `goodsreceivenotehed`
--
ALTER TABLE `goodsreceivenotehed`
  ADD PRIMARY KEY (`AppNo`,`GRN_No`,`GRN_Location`);

--
-- Indexes for table `grnsettlementdetails`
--
ALTER TABLE `grnsettlementdetails`
  ADD PRIMARY KEY (`SupPayNo`,`GRNNo`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday_schedule`
--
ALTER TABLE `holiday_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insu_company`
--
ALTER TABLE `insu_company`
  ADD PRIMARY KEY (`InsuranceId`);

--
-- Indexes for table `internal_transferdtl`
--
ALTER TABLE `internal_transferdtl`
  ADD PRIMARY KEY (`TrnsNo`,`Location`,`ProductCode`,`CaseOrUnit`,`IsSerial`,`Serial`);

--
-- Indexes for table `internal_transferhed`
--
ALTER TABLE `internal_transferhed`
  ADD PRIMARY KEY (`AppNo`,`Location`,`TrnsNo`);

--
-- Indexes for table `invoicedtl`
--
ALTER TABLE `invoicedtl`
  ADD PRIMARY KEY (`AppNo`,`InvNo`,`InvLocation`,`InvLineNo`,`InvProductCode`);

--
-- Indexes for table `invoicehed`
--
ALTER TABLE `invoicehed`
  ADD PRIMARY KEY (`AppNo`,`InvNo`,`InvLocation`);

--
-- Indexes for table `invoicepaydtl`
--
ALTER TABLE `invoicepaydtl`
  ADD PRIMARY KEY (`AppNo`,`InvNo`,`InvPayType`,`Mode`);

--
-- Indexes for table `invoicerefund`
--
ALTER TABLE `invoicerefund`
  ADD PRIMARY KEY (`AppNo`,`Location`,`RefundNo`);

--
-- Indexes for table `invoicesettlementdetails`
--
ALTER TABLE `invoicesettlementdetails`
  ADD PRIMARY KEY (`CusPayNo`,`InvNo`);

--
-- Indexes for table `invoice_condition`
--
ALTER TABLE `invoice_condition`
  ADD PRIMARY KEY (`InvRemarkId`);

--
-- Indexes for table `invoice_dtl`
--
ALTER TABLE `invoice_dtl`
  ADD PRIMARY KEY (`InvNo`,`AccNo`,`InvProductCode`);

--
-- Indexes for table `invoice_extra_amount`
--
ALTER TABLE `invoice_extra_amount`
  ADD PRIMARY KEY (`AccNo`,`InvNo`,`ExtraNo`);

--
-- Indexes for table `invoice_hed`
--
ALTER TABLE `invoice_hed`
  ADD PRIMARY KEY (`InvNo`);

--
-- Indexes for table `inv_jobdescription`
--
ALTER TABLE `inv_jobdescription`
  ADD PRIMARY KEY (`JobDescNo`);

--
-- Indexes for table `inv_type`
--
ALTER TABLE `inv_type`
  ADD PRIMARY KEY (`invtype_id`);

--
-- Indexes for table `issuenote_dtl`
--
ALTER TABLE `issuenote_dtl`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesInvLocation`,`SalesInvLineNo`,`SalesProductCode`);

--
-- Indexes for table `issuenote_hed`
--
ALTER TABLE `issuenote_hed`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesLocation`);

--
-- Indexes for table `item_charges`
--
ALTER TABLE `item_charges`
  ADD PRIMARY KEY (`ChargeId`);

--
-- Indexes for table `item_interest`
--
ALTER TABLE `item_interest`
  ADD PRIMARY KEY (`IntId`);

--
-- Indexes for table `item_payment_dtl`
--
ALTER TABLE `item_payment_dtl`
  ADD PRIMARY KEY (`AccNo`,`Month`);

--
-- Indexes for table `jobcardhed`
--
ALTER TABLE `jobcardhed`
  ADD PRIMARY KEY (`JobCardNo`);

--
-- Indexes for table `jobcardtype`
--
ALTER TABLE `jobcardtype`
  ADD PRIMARY KEY (`JobCardNo`,`JobTypeId`);

--
-- Indexes for table `jobcategory`
--
ALTER TABLE `jobcategory`
  ADD PRIMARY KEY (`jobcategory_id`);

--
-- Indexes for table `jobcompanyinvoicedetails`
--
ALTER TABLE `jobcompanyinvoicedetails`
  ADD PRIMARY KEY (`AppNo`,`ComInvoiceNo`,`ComLocation`,`ComCusCode`);

--
-- Indexes for table `jobcreditinvoicedetails`
--
ALTER TABLE `jobcreditinvoicedetails`
  ADD PRIMARY KEY (`AppNo`,`InvoiceNo`,`Location`,`CusCode`);

--
-- Indexes for table `jobdescription`
--
ALTER TABLE `jobdescription`
  ADD PRIMARY KEY (`JobDescNo`);

--
-- Indexes for table `jobinvoicedtl`
--
ALTER TABLE `jobinvoicedtl`
  ADD PRIMARY KEY (`jobinvoicedtlid`);

--
-- Indexes for table `jobinvoicehed`
--
ALTER TABLE `jobinvoicehed`
  ADD PRIMARY KEY (`JobInvNo`,`JobCardNo`);

--
-- Indexes for table `jobinvoicepaydtl`
--
ALTER TABLE `jobinvoicepaydtl`
  ADD PRIMARY KEY (`JobInvNo`,`JobInvPayType`);

--
-- Indexes for table `jobpackagedtl`
--
ALTER TABLE `jobpackagedtl`
  ADD PRIMARY KEY (`jobinvoicedtlid`);

--
-- Indexes for table `jobpackagehed`
--
ALTER TABLE `jobpackagehed`
  ADD PRIMARY KEY (`JobInvNo`,`JobCardNo`);

--
-- Indexes for table `jobtype`
--
ALTER TABLE `jobtype`
  ADD PRIMARY KEY (`jobtype_id`);

--
-- Indexes for table `jobtypeheader`
--
ALTER TABLE `jobtypeheader`
  ADD PRIMARY KEY (`jobhead_id`);

--
-- Indexes for table `jobwoker`
--
ALTER TABLE `jobwoker`
  ADD PRIMARY KEY (`jworkid`);

--
-- Indexes for table `job_condition`
--
ALTER TABLE `job_condition`
  ADD PRIMARY KEY (`JobConId`);

--
-- Indexes for table `job_document`
--
ALTER TABLE `job_document`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `job_section`
--
ALTER TABLE `job_section`
  ADD PRIMARY KEY (`JobSecNo`);

--
-- Indexes for table `job_status`
--
ALTER TABLE `job_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `make`
--
ALTER TABLE `make`
  ADD PRIMARY KEY (`make_id`);

--
-- Indexes for table `materialrequestnotedtl`
--
ALTER TABLE `materialrequestnotedtl`
  ADD PRIMARY KEY (`MrnNo`,`Location`,`ProductCode`,`IsSerial`,`Serial`,`ProName`);

--
-- Indexes for table `materialrequestnotehed`
--
ALTER TABLE `materialrequestnotehed`
  ADD PRIMARY KEY (`AppNo`,`Location`,`MrnNo`);

--
-- Indexes for table `measure`
--
ALTER TABLE `measure`
  ADD PRIMARY KEY (`UOM_No`);

--
-- Indexes for table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `parttype`
--
ALTER TABLE `parttype`
  ADD PRIMARY KEY (`parttype_id`);

--
-- Indexes for table `paytype`
--
ALTER TABLE `paytype`
  ADD PRIMARY KEY (`payTypeId`);

--
-- Indexes for table `penalty_setting`
--
ALTER TABLE `penalty_setting`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permission_class`,`per_user`,`isClass`);

--
-- Indexes for table `pricelevel`
--
ALTER TABLE `pricelevel`
  ADD PRIMARY KEY (`PL_No`);

--
-- Indexes for table `pricestock`
--
ALTER TABLE `pricestock`
  ADD PRIMARY KEY (`PSCode`,`PSLocation`,`PSPriceLevel`,`Price`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductCode`);

--
-- Indexes for table `productbrand`
--
ALTER TABLE `productbrand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `productcategory`
--
ALTER TABLE `productcategory`
  ADD PRIMARY KEY (`ProductCode`);

--
-- Indexes for table `productcondition`
--
ALTER TABLE `productcondition`
  ADD PRIMARY KEY (`ProductCode`);

--
-- Indexes for table `productlocation`
--
ALTER TABLE `productlocation`
  ADD PRIMARY KEY (`ProductCode`,`ProLocation`);

--
-- Indexes for table `productprice`
--
ALTER TABLE `productprice`
  ADD PRIMARY KEY (`ProductCode`,`PL_No`);

--
-- Indexes for table `productqtywisepricegroup`
--
ALTER TABLE `productqtywisepricegroup`
  ADD PRIMARY KEY (`MaxNo`,`ProductCode`);

--
-- Indexes for table `productquality`
--
ALTER TABLE `productquality`
  ADD PRIMARY KEY (`QualityID`);

--
-- Indexes for table `productserialstock`
--
ALTER TABLE `productserialstock`
  ADD PRIMARY KEY (`ProductCode`,`Location`,`SerialNo`);

--
-- Indexes for table `productstock`
--
ALTER TABLE `productstock`
  ADD PRIMARY KEY (`ProductCode`,`Location`);

--
-- Indexes for table `producttempstock`
--
ALTER TABLE `producttempstock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productCode_idx` (`productCode`);

--
-- Indexes for table `public_preferences`
--
ALTER TABLE `public_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorderdtl`
--
ALTER TABLE `purchaseorderdtl`
  ADD PRIMARY KEY (`PO_Id`);

--
-- Indexes for table `purchaseorderhed`
--
ALTER TABLE `purchaseorderhed`
  ADD PRIMARY KEY (`AppNo`,`PO_No`,`PO_Location`);

--
-- Indexes for table `purchasereturnnotedtl`
--
ALTER TABLE `purchasereturnnotedtl`
  ADD PRIMARY KEY (`AppNo`,`PRN_No`,`PRN_Product`,`PRN_Selling`,`Serial`);

--
-- Indexes for table `purchasereturnnotehed`
--
ALTER TABLE `purchasereturnnotehed`
  ADD PRIMARY KEY (`AppNo`,`PRN_No`);

--
-- Indexes for table `rack`
--
ALTER TABLE `rack`
  ADD PRIMARY KEY (`rack_id`);

--
-- Indexes for table `received_invoices`
--
ALTER TABLE `received_invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `received_invoices_items`
--
ALTER TABLE `received_invoices_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `InvoiceID` (`InvoiceID`);

--
-- Indexes for table `rental_extra_amount`
--
ALTER TABLE `rental_extra_amount`
  ADD PRIMARY KEY (`AccNo`,`InvNo`,`ExtraNo`);

--
-- Indexes for table `rental_paid`
--
ALTER TABLE `rental_paid`
  ADD PRIMARY KEY (`PaymentId`,`PaymentType`,`InvNo`);

--
-- Indexes for table `rental_payment_dtl`
--
ALTER TABLE `rental_payment_dtl`
  ADD PRIMARY KEY (`AccNo`,`Month`);

--
-- Indexes for table `reschedule`
--
ALTER TABLE `reschedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returninvoicedtl`
--
ALTER TABLE `returninvoicedtl`
  ADD PRIMARY KEY (`AppNo`,`ReturnNo`,`ProductCode`,`SellingPrice`,`SerialNo`);

--
-- Indexes for table `returninvoicehed`
--
ALTER TABLE `returninvoicehed`
  ADD PRIMARY KEY (`AppNo`,`ReturnNo`,`ReturnLocation`,`InvoiceNo`);

--
-- Indexes for table `returnnoninvoicessettle`
--
ALTER TABLE `returnnoninvoicessettle`
  ADD PRIMARY KEY (`AppNo`,`ReturnNo`,`ReturnLocation`,`InvCount`,`InvoiceNo`);

--
-- Indexes for table `return_payment`
--
ALTER TABLE `return_payment`
  ADD PRIMARY KEY (`ReturnNo`),
  ADD KEY `ReturnLocation_2` (`ReturnLocation`);

--
-- Indexes for table `return_types`
--
ALTER TABLE `return_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `salesinvoicedtl`
--
ALTER TABLE `salesinvoicedtl`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesInvLocation`,`SalesInvLineNo`,`SalesProductCode`);

--
-- Indexes for table `salesinvoicedtl_copy`
--
ALTER TABLE `salesinvoicedtl_copy`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesInvLocation`,`SalesInvLineNo`,`SalesProductCode`);

--
-- Indexes for table `salesinvoicehed`
--
ALTER TABLE `salesinvoicehed`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesLocation`);

--
-- Indexes for table `salesinvoicepaydtl`
--
ALTER TABLE `salesinvoicepaydtl`
  ADD PRIMARY KEY (`AppNo`,`SalesInvNo`,`SalesInvPayType`,`Mode`);

--
-- Indexes for table `salespersons`
--
ALTER TABLE `salespersons`
  ADD PRIMARY KEY (`RepID`);

--
-- Indexes for table `salespersons_copy`
--
ALTER TABLE `salespersons_copy`
  ADD PRIMARY KEY (`RepID`);

--
-- Indexes for table `skill_level`
--
ALTER TABLE `skill_level`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `sms_config`
--
ALTER TABLE `sms_config`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ProductCode`,`Location`);

--
-- Indexes for table `stockdate`
--
ALTER TABLE `stockdate`
  ADD PRIMARY KEY (`ProductCode`,`StockDate`,`Location`);

--
-- Indexes for table `stockdateuser`
--
ALTER TABLE `stockdateuser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocktransferdtl`
--
ALTER TABLE `stocktransferdtl`
  ADD PRIMARY KEY (`TrnsNo`,`Location`,`ProductCode`,`CaseOrUnit`,`IsSerial`,`Serial`);

--
-- Indexes for table `stocktransferhed`
--
ALTER TABLE `stocktransferhed`
  ADD PRIMARY KEY (`AppNo`,`Location`,`TrnsNo`);

--
-- Indexes for table `store_location`
--
ALTER TABLE `store_location`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `subcategory`
--
ALTER TABLE `subcategory`
  ADD PRIMARY KEY (`DepCode`,`SubDepCode`,`CategoryCode`,`SubCategoryCode`);

--
-- Indexes for table `subdepartment`
--
ALTER TABLE `subdepartment`
  ADD PRIMARY KEY (`DepCode`,`SubDepCode`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`SupCode`);

--
-- Indexes for table `supplieroustanding`
--
ALTER TABLE `supplieroustanding`
  ADD PRIMARY KEY (`SupCode`);

--
-- Indexes for table `supplierpaymentdtl`
--
ALTER TABLE `supplierpaymentdtl`
  ADD PRIMARY KEY (`AppNo`,`Location`,`SupPayNo`,`Mode`);

--
-- Indexes for table `supplierpaymenthed`
--
ALTER TABLE `supplierpaymenthed`
  ADD PRIMARY KEY (`AppNo`,`SupPayNo`,`Location`,`SupCode`);

--
-- Indexes for table `systemoptions`
--
ALTER TABLE `systemoptions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `system_module`
--
ALTER TABLE `system_module`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_permission_define`
--
ALTER TABLE `system_permission_define`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `per_code` (`per_code`),
  ADD UNIQUE KEY `per_code_2` (`per_code`),
  ADD UNIQUE KEY `per_code_3` (`per_code`);

--
-- Indexes for table `system_permission_set`
--
ALTER TABLE `system_permission_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempjobinvoicedtl`
--
ALTER TABLE `tempjobinvoicedtl`
  ADD PRIMARY KEY (`jobinvoicedtlid`);

--
-- Indexes for table `tempjobinvoicehed`
--
ALTER TABLE `tempjobinvoicehed`
  ADD PRIMARY KEY (`JobInvNo`,`JobCardNo`);

--
-- Indexes for table `tempsalesfreeitem`
--
ALTER TABLE `tempsalesfreeitem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tempsalesinvoicehed`
--
ALTER TABLE `tempsalesinvoicehed`
  ADD PRIMARY KEY (`tempInvId`,`tempInvNo`) USING BTREE,
  ADD KEY `routeId_idx` (`routeId`),
  ADD KEY `customerId_idx` (`customerId`);

--
-- Indexes for table `tempsalesinvoiceheddtl`
--
ALTER TABLE `tempsalesinvoiceheddtl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `title`
--
ALTER TABLE `title`
  ADD PRIMARY KEY (`TitleId`);

--
-- Indexes for table `transactiontypes`
--
ALTER TABLE `transactiontypes`
  ADD PRIMARY KEY (`TransactionCode`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `vehicledetail`
--
ALTER TABLE `vehicledetail`
  ADD PRIMARY KEY (`VehicleId`);

--
-- Indexes for table `vehicle_company`
--
ALTER TABLE `vehicle_company`
  ADD PRIMARY KEY (`VComId`);

--
-- Indexes for table `warrantydetails`
--
ALTER TABLE `warrantydetails`
  ADD PRIMARY KEY (`AppNo`,`InvLocation`,`InvNo`,`InvProductCode`,`InvSerialNo`);

--
-- Indexes for table `warranty_typs`
--
ALTER TABLE `warranty_typs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `DepNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `acc_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `body_color`
--
ALTER TABLE `body_color`
  MODIFY `bodycolor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chequedetails`
--
ALTER TABLE `chequedetails`
  MODIFY `AutoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `class_function`
--
ALTER TABLE `class_function`
  MODIFY `function_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `clearproductlog`
--
ALTER TABLE `clearproductlog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clearseriallog`
--
ALTER TABLE `clearseriallog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `code_genarate`
--
ALTER TABLE `code_genarate`
  MODIFY `RefId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customerorderdtl`
--
ALTER TABLE `customerorderdtl`
  MODIFY `PO_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customerorderpayment`
--
ALTER TABLE `customerorderpayment`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_account_type`
--
ALTER TABLE `customer_account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_avc`
--
ALTER TABLE `customer_avc`
  MODIFY `cc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_category`
--
ALTER TABLE `customer_category`
  MODIFY `CusCatId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `CusTypeId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cus_document`
--
ALTER TABLE `cus_document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editinvoices`
--
ALTER TABLE `editinvoices`
  MODIFY `Editid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `employeeroutes`
--
ALTER TABLE `employeeroutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `emp_type`
--
ALTER TABLE `emp_type`
  MODIFY `EmpTypeNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `estimatedtl`
--
ALTER TABLE `estimatedtl`
  MODIFY `estimatedtlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estimate_jobtype`
--
ALTER TABLE `estimate_jobtype`
  MODIFY `EstimateJobNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estimate_type`
--
ALTER TABLE `estimate_type`
  MODIFY `EstimateTypeNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estimate_worktype`
--
ALTER TABLE `estimate_worktype`
  MODIFY `estimate_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `est_document`
--
ALTER TABLE `est_document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fuel_type`
--
ALTER TABLE `fuel_type`
  MODIFY `fuel_typeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `holiday_schedule`
--
ALTER TABLE `holiday_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `insu_company`
--
ALTER TABLE `insu_company`
  MODIFY `InsuranceId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_condition`
--
ALTER TABLE `invoice_condition`
  MODIFY `InvRemarkId` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inv_jobdescription`
--
ALTER TABLE `inv_jobdescription`
  MODIFY `JobDescNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inv_type`
--
ALTER TABLE `inv_type`
  MODIFY `invtype_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `item_charges`
--
ALTER TABLE `item_charges`
  MODIFY `ChargeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_interest`
--
ALTER TABLE `item_interest`
  MODIFY `IntId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobcategory`
--
ALTER TABLE `jobcategory`
  MODIFY `jobcategory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobdescription`
--
ALTER TABLE `jobdescription`
  MODIFY `JobDescNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobinvoicedtl`
--
ALTER TABLE `jobinvoicedtl`
  MODIFY `jobinvoicedtlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobpackagedtl`
--
ALTER TABLE `jobpackagedtl`
  MODIFY `jobinvoicedtlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobtype`
--
ALTER TABLE `jobtype`
  MODIFY `jobtype_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobtypeheader`
--
ALTER TABLE `jobtypeheader`
  MODIFY `jobhead_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobwoker`
--
ALTER TABLE `jobwoker`
  MODIFY `jworkid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_condition`
--
ALTER TABLE `job_condition`
  MODIFY `JobConId` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `job_document`
--
ALTER TABLE `job_document`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_section`
--
ALTER TABLE `job_section`
  MODIFY `JobSecNo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `make`
--
ALTER TABLE `make`
  MODIFY `make_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model`
--
ALTER TABLE `model`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parttype`
--
ALTER TABLE `parttype`
  MODIFY `parttype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paytype`
--
ALTER TABLE `paytype`
  MODIFY `payTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penalty_setting`
--
ALTER TABLE `penalty_setting`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productbrand`
--
ALTER TABLE `productbrand`
  MODIFY `BrandID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `productquality`
--
ALTER TABLE `productquality`
  MODIFY `QualityID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `producttempstock`
--
ALTER TABLE `producttempstock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `public_preferences`
--
ALTER TABLE `public_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchaseorderdtl`
--
ALTER TABLE `purchaseorderdtl`
  MODIFY `PO_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rack`
--
ALTER TABLE `rack`
  MODIFY `rack_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `received_invoices`
--
ALTER TABLE `received_invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `received_invoices_items`
--
ALTER TABLE `received_invoices_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reschedule`
--
ALTER TABLE `reschedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_types`
--
ALTER TABLE `return_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `skill_level`
--
ALTER TABLE `skill_level`
  MODIFY `skill_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sms_config`
--
ALTER TABLE `sms_config`
  MODIFY `sms_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stockdateuser`
--
ALTER TABLE `stockdateuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_location`
--
ALTER TABLE `store_location`
  MODIFY `store_id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_module`
--
ALTER TABLE `system_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `system_permission_define`
--
ALTER TABLE `system_permission_define`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `system_permission_set`
--
ALTER TABLE `system_permission_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `tempjobinvoicedtl`
--
ALTER TABLE `tempjobinvoicedtl`
  MODIFY `jobinvoicedtlid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tempsalesfreeitem`
--
ALTER TABLE `tempsalesfreeitem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tempsalesinvoicehed`
--
ALTER TABLE `tempsalesinvoicehed`
  MODIFY `tempInvId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tempsalesinvoiceheddtl`
--
ALTER TABLE `tempsalesinvoiceheddtl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `title`
--
ALTER TABLE `title`
  MODIFY `TitleId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `vehicledetail`
--
ALTER TABLE `vehicledetail`
  MODIFY `VehicleId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_company`
--
ALTER TABLE `vehicle_company`
  MODIFY `VComId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warranty_typs`
--
ALTER TABLE `warranty_typs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `received_invoices_items`
--
ALTER TABLE `received_invoices_items`
  ADD CONSTRAINT `received_invoices_items_ibfk_1` FOREIGN KEY (`InvoiceID`) REFERENCES `received_invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`nsoftsoft`@`localhost` EVENT `update_daily_stock` ON SCHEDULE EVERY 1 DAY STARTS '2016-10-11 23:00:00' ON COMPLETION PRESERVE ENABLE DO INSERT INTO stockdate
           (`ProductCode`,`StockDate`,`Stock`,`Location`)
SELECT productstock.ProductCode , CURDATE() , productstock.Stock,productstock.Location
FROM productstock INNER JOIN productcondition ON productcondition.ProductCode=productstock.ProductCode
WHERE productcondition.IsSerial=1$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
