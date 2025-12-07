import { S3Client, GetObjectCommand, PutObjectCommand } from "@aws-sdk/client-s3";

const s3Client = new S3Client({ region: "eu-west-2" });

export const handler = async (event) => {
    console.log("Event received:", JSON.stringify(event, null, 2));
    
    // Get bucket and key info from the S3 event
    const bucket = event.Records[0].s3.bucket.name;
    const key = decodeURIComponent(event.Records[0].s3.object.key.replace(/\+/g, ' '));
    
    console.log(`Processing file: ${key} from bucket: ${bucket}`);
    
    try {
        // Read the source file from S3
        const getCommand = new GetObjectCommand({
            Bucket: bucket,
            Key: key
        });
        
        const response = await s3Client.send(getCommand);
        const imageBuffer = await streamToBuffer(response.Body);
        
        console.log(`Original image size: ${imageBuffer.length} bytes`);
        
        // TODO: Add the sharp library for real compression
        // For now, save the same file with the "compressed-" prefix
        const compressedKey = key.replace('user-', 'compressed-');
        
        const putCommand = new PutObjectCommand({
            Bucket: "yourbucket-s3-compressed",
            Key: compressedKey,
            Body: imageBuffer,
            ContentType: response.ContentType
        });
        
        await s3Client.send(putCommand);
        
        console.log(`File saved to: yourbucket-s3-compressed/${compressedKey}`);
        
        return {
            statusCode: 200,
            body: JSON.stringify({
                message: 'Image processed successfully',
                originalSize: imageBuffer.length,
                compressedFile: `yourbucket-s3-compressed/${compressedKey}`
            })
        };
        
    } catch (error) {
        console.error("Error processing image:", error);
        throw error;
    }
};

// Helper function: Convert stream to Buffer
async function streamToBuffer(stream) {
    const chunks = [];
    for await (const chunk of stream) {
        chunks.push(chunk);
    }
    return Buffer.concat(chunks);
}
