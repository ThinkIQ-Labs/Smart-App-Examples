# Smart App Infrastructure Project
This repository contains an overview of the Smart App Infrastructure project, example smart apps, training video, and other project learnings.

## What was the Problem that this Project sought to Solve?
To drive adoption and usage the CESMII SMIP needs to provide an open architecture to support the development and integration of Smart Apps created by software vendors, end-user manufacturers or other third parties who are looking to solve business problems.

Without this any development of Smart Apps will result in higher costs and time to develop due to the level of infrastructure worked required for use of, and integration to the SMIP. 

## What is the Project Objective?
This project will significantly enhance the existing SMIP platform to support multi-vendor environment for the development, deployment, management, and administration of Smart Apps. 

Smart apps will have the following capabilities as a result of this project:
- To integrate into the Content Management System.
- To participate in Licensing and Usage services offered by the platform.
- To upgrade from the administrative section of the Platform’s Content Management System.
- When standing up a new platform instance, Smart Apps will be selectable from a list to be automatically created as part of the new platform instance.
- To use SMIP services for Language Switching, Localization and Security Role awareness. 

## Technical Approach
The existing SMIP was extended to provide a robust middle-tier API’s which provides programmatic access to the various service provided by the Content Management System. Also, Platform Services were developed to support independent APP deployment, upgrades, and administration.

## Potential Impact
By making these significant changes to the SMIP, the platform now provides the infrastructure to better allow vendors to create and launch their own Smart Applications. With the completion of this project, we expect a significant cost reduction (approx. 50%) in the development of Smart Apps by vendors.

## Benefit
This functionality will increase the number of Vendors that are likely to build applications within the platform. It will be particularly attractive to System Integrators who are typically unable to afford the costs of creating all the supporting infrastructure needed to create a full platform.

# Smart Apps
Smart Apps are applications built to interface with the Smart Manufacturing Innovation Platform and extend its built in functionality. They can be hosted within the platform or connect to it externally to read/write data through the context of the model. Due to the extensible nature of the platform, the possibilities are enormous. Here are some basic examples of Smarts Apps and some resources to inspire creators.

## Examples:
### Content Management System Modules
These Modules are examples of Smart Apps that are directly integrated into the platform through the CMS. They leverage the ThinkIQ UI components to create 'drag and drop' Modules that can be used to the create live web pages within the CMS that are Model aware. Their source lives [here](CMS-Modules) and can be mimicked to create Smart Apps that exist with the platform's CMS.

### Weather Station Library
This library is an example of the flexible and powerful choice of using libraries to create Smart Apps. These Apps are created within the Model itself and can be exported into other platform instances. See the detailed example [here](Weather-Station-Library).

### Stand-Alone Applications
Stand-Alone applications can are hosted outside of a platform instance but connect to it through its secure external APIs. These applications are excellent for solutions for third parties that want to integrate with the platform. See an example [here](https://github.com/ThinkIQ-Labs/SMIP-SMX-2022-Demos)

## Resources:
When creating a Smart App there are many tools that can be used to forge a solution. For developers looking to get started here are some links to documentation and examples.

- CMS API 
  - Docs: https://api.joomla.org/cms-4/namespaces/joomla-cms.html
  - Example: https://docs.joomla.org/Accessing_the_current_user_object
- Model API
  - Docs: https://help.thinkiq.com/phputilities/
  - See Script Templates and the [Weather Station Library](Weather-Station-Library) for examples
    
- Smart App Update and Deployment Services
  - Complete example/docs: https://docs.joomla.org/J3.x:Developing_an_MVC_Component/Developing_a_Basic_Component

[Training video](Smart%20App%20Training%20Overview.mov)


