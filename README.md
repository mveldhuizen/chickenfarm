# ChickenFarm Developer Job

## Introduction
A Farmer is looking to make more money in the future and wants to improve his current chicken departement. Before he can make a decision on what he should change he needs to know how his farm is doing. He taught about a way to get some metrics about the upcoming year and is looking for a Developer to build this for him.

## Description
The farm has one barn with 50 chickens. Those chickens can lay between 0 to 2 eggs a day. In the past the farmer already thought about some optimization and gave all the chickens a unique chip with a number ( example: 20190101-1 {date of birth}-{unique number} ) so he can follow all the individual chickens. He wants to know the following things:

- How many eggs are produced in the measured period ?
- How many eggs will be fertilized in the measured period ( The chance for a fertilized egg will be 50% ) ?
- Which of the chickens produced the most eggs in the measured period ?
- Which of the chickens fertilized the most eggs in the measured period ?
- What will be the total revenue when the unfertilized eggs will be sold for 0.25 cent each ?
- How many new chickens will be born in the measured period ( a new born chicken can lay eggs 4 months after his egg was produced and can have fertilized eggs 8 months after his egg was produced ) ?

## Additional information
- The period of time for the measurement is 365 days.
- The start date for the measurement will be the 1st of January of the current year
- All the current chickens ( 50 ) when we start the measurement are born in april last year

## Requirements
- The solution should only contain one single PHP File. When the php file is called it should return the values described in the description. The file may contain multiple classes, interfaces if required.
- The solution should support / use the latest version of PHP
- No framework can be used to solve this assignment
- No Database can be used to store data
- Every question of the Description section should result in a output line when running the script
- The code should be as clean and optimized as possible
